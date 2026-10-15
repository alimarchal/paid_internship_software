<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\RandomUserQuestion;
use App\Models\User;
use App\Services\ExamPaperBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class BatchExamController extends Controller
{
    /** Filters that narrow the list. When any is used (and no row limit is picked) every match is shown. */
    private const FILTERS = ['batch_no', 'status', 'profile_status', 'district_of_domicile', 'test_center', 'exam_state', 'search'];

    public function index(Request $request, ExamPaperBuilder $builder)
    {
        $hasFilters = $request->hasAny(self::FILTERS) && collect(self::FILTERS)->contains(fn ($k) => $request->filled($k));
        $perPage = $request->input('per_page');
        $showAll = $perPage === 'all' || ($hasFilters && ! $request->filled('per_page'));

        $query = $this->filteredQuery($request)->orderBy('id');
        $candidates = $showAll ? $query->get() : $query->paginate((int) $perPage ?: 50)->withQueryString();
        $matching = $showAll ? $candidates->count() : $candidates->total();

        return view('settings.batch-exam.index', [
            'candidates' => $candidates,
            'paginated' => ! $showAll,
            'hasFilters' => $hasFilters,
            'categories' => Category::orderBy('name')->get(),
            'available' => $builder->availability(),
            'allocated' => RandomUserQuestion::whereIn('user_id', $candidates->pluck('id'))->selectRaw('user_id, count(*) n')->groupBy('user_id')->pluck('n', 'user_id'),
            'matching' => $matching,
        ]);
    }

    public function apply(Request $request, ExamPaperBuilder $builder)
    {
        $data = $request->validate([
            'ids' => ['array'],
            'ids.*' => ['integer'],
            'select_all_matching' => ['nullable', 'boolean'],
            'start_test' => ['nullable', Rule::in(['', '0', '1'])],
            'change_password' => ['nullable', 'boolean'],
            'password' => ['nullable', 'required_if:change_password,1', 'string', 'min:8'],
            'start_test_time' => ['nullable', 'date'],
            'end_test_time' => ['nullable', 'date', 'after:start_test_time'],
            'paper' => ['nullable', Rule::in(['', 'set', 'default'])],
            'total_questions' => ['nullable', 'required_if:paper,set', 'integer', 'min:1', 'max:500'],
            'category_counts' => ['nullable', 'array'],
            'category_counts.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $query = $request->boolean('select_all_matching')
            ? $this->filteredQuery($request)
            : User::role('Intern')->whereIn('id', $data['ids'] ?? []);

        $count = (clone $query)->count();
        if ($count === 0) {
            return back()->withInput()->with('error', 'No candidates selected.');
        }

        $update = [];

        if (($data['start_test'] ?? '') !== '') {
            $update['start_test'] = (int) $data['start_test'];
        }
        if ($request->boolean('change_password')) {
            $update['password'] = Hash::make($data['password']);
        }
        if (!empty($data['start_test_time'])) {
            $update['start_test_time'] = Carbon::parse($data['start_test_time']);
        }
        if (!empty($data['end_test_time'])) {
            $update['end_test_time'] = Carbon::parse($data['end_test_time']);
        }

        if (($data['paper'] ?? '') === 'default') {
            $update['exam_config'] = null;
        } elseif (($data['paper'] ?? '') === 'set') {
            $counts = collect($data['category_counts'] ?? [])->map(fn ($n) => (int) $n)->filter(fn ($n) => $n > 0);
            $available = $builder->availability();

            if ($counts->sum() !== (int) $data['total_questions']) {
                return back()->withInput()->withErrors(['total_questions' => 'Category-wise counts add up to '.$counts->sum().', but total questions is '.$data['total_questions'].'.']);
            }
            foreach ($counts as $categoryId => $n) {
                if ($n > ($available[$categoryId] ?? 0)) {
                    $name = Category::find($categoryId)?->name ?? $categoryId;

                    return back()->withInput()->withErrors(['category_counts' => "{$name} has only ".($available[$categoryId] ?? 0)." questions, but {$n} were requested."]);
                }
            }

            $update['exam_config'] = json_encode(['total' => (int) $data['total_questions'], 'categories' => $counts->all()]);
        }

        if (!$update) {
            return back()->withInput()->with('error', 'Nothing to change. Fill at least one option.');
        }

        $query->update($update + ['updated_at' => now()]);

        return redirect()->route('settings.batch-exam.index', $request->query())
            ->with('success', "Updated {$count} candidate(s).");
    }

    private function filteredQuery(Request $request)
    {
        return User::role('Intern')
            ->when($request->filled('batch_no'), fn ($q) => $q->where('batch_no', $request->batch_no))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('profile_status'), fn ($q) => $q->where('profile_status', $request->profile_status))
            ->when($request->filled('district_of_domicile'), fn ($q) => $q->where('district_of_domicile', $request->district_of_domicile))
            ->when($request->filled('test_center'), fn ($q) => $q->where('test_center', $request->test_center))
            ->when($request->filled('exam_state'), function ($q) use ($request) {
                match ($request->exam_state) {
                    'not_allowed' => $q->where('start_test', 0),
                    'allowed' => $q->where('start_test', 1)->where('exam_taken', 0),
                    'finished' => $q->where('exam_taken', 1),
                    default => null,
                };
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                $q->where(fn ($w) => $w->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('cnic_number', 'like', "%{$s}%")->orWhere('id', $s));
            });
    }
}
