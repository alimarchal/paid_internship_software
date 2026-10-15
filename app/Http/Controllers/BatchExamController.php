<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\RandomUserQuestion;
use App\Models\User;
use App\Services\ExamPaperBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BatchExamController extends Controller
{
    public const PER_PAGE = [10, 50, 100, 'all'];

    public function index(Request $request, ExamPaperBuilder $builder)
    {
        $hasFilters = collect($request->query('filter', []))->contains(fn ($v) => $v !== null && $v !== '');

        // Default 50 per page with pagination; the user can switch to 10 / 100 / all.
        $perPage = in_array($request->query('per_page'), array_map('strval', self::PER_PAGE), true) ? $request->query('per_page') : '50';
        $showAll = $perPage === 'all';

        $query = $this->filteredQuery($request)->defaultSort('id');
        $candidates = $showAll ? $query->get() : $query->paginate((int) $perPage)->withQueryString();
        $matching = $showAll ? $candidates->count() : $candidates->total();

        return view('settings.batch-exam.index', [
            'candidates' => $candidates,
            'paginated' => ! $showAll,
            'perPage' => $perPage,
            'hasFilters' => $hasFilters,
            'categories' => Category::orderBy('name')->get(),
            'available' => $builder->availability(),
            'allocated' => RandomUserQuestion::whereIn('user_id', $candidates->pluck('id'))->selectRaw('user_id, count(*) n')->groupBy('user_id')->pluck('n', 'user_id'),
            'matching' => $matching,
            'testCenters' => User::role('Intern')->whereNotNull('test_center')->distinct()->orderBy('test_center')->pluck('test_center'),
            'degreeLevels' => User::role('Intern')->whereNotNull('degree_level')->distinct()->orderBy('degree_level')->pluck('degree_level'),
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
            'set_status' => ['nullable', Rule::in(['', 'Shortlisted', 'Pending', 'Rejected'])],
            'status_comment' => ['nullable', 'string', 'max:255'],
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

        // Status changes also write a comment row, like the single Shortlist/Reject action (the candidate list filters on it).
        $newStatus = $data['set_status'] ?? '';
        $statusIds = collect();
        if ($newStatus !== '') {
            $update['status'] = $newStatus;
            $statusIds = (clone $query)->pluck('id');
        }

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

        DB::transaction(function () use ($query, $update, $newStatus, $statusIds, $data) {
            $query->update($update + ['updated_at' => now()]);

            if ($newStatus !== '' && $statusIds->isNotEmpty()) {
                $comment = trim($data['status_comment'] ?? '') ?: "{$newStatus} in bulk from Settings";
                foreach ($statusIds->chunk(500) as $chunk) {
                    Comment::insert($chunk->map(fn ($id) => [
                        'user_id' => $id,
                        'user_id_comment_by' => auth()->id(),
                        'comments' => $comment,
                        'status' => $newStatus,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])->all());
                }
            }
        });

        return redirect()->route('settings.batch-exam.index', $request->query())
            ->with('success', "Updated {$count} candidate(s).");
    }

    /** Same filter[...] / sort convention as the rest of the app (Spatie Query Builder). */
    private function filteredQuery(Request $request): QueryBuilder
    {
        return QueryBuilder::for(User::role('Intern'), $request)
            ->allowedFilters(
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('fathers_name'),
                AllowedFilter::partial('email'),
                AllowedFilter::partial('cnic_number'),
                AllowedFilter::partial('contact_number'),
                AllowedFilter::exact('batch_no'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('profile_status'),
                AllowedFilter::exact('gender'),
                AllowedFilter::exact('religion'),
                AllowedFilter::exact('marital_status'),
                AllowedFilter::exact('district'),
                AllowedFilter::exact('district_of_domicile'),
                // Values here may contain commas, which Query Builder would otherwise split into an array.
                AllowedFilter::callback('degree_level', fn ($q, $v) => $q->where('degree_level', is_array($v) ? implode(',', $v) : $v)),
                AllowedFilter::callback('test_center', fn ($q, $v) => $q->where('test_center', is_array($v) ? implode(',', $v) : $v)),
                AllowedFilter::exact('test_date'),
                AllowedFilter::exact('education_degrees_search.major_subject'),
                AllowedFilter::callback('exam_state', function ($q, $value) {
                    match ($value) {
                        'not_allowed' => $q->where('start_test', 0),
                        'allowed' => $q->where('start_test', 1)->where('exam_taken', 0),
                        'finished' => $q->where('exam_taken', 1),
                        default => null,
                    };
                }),
                AllowedFilter::callback('paper', function ($q, $value) {
                    match ($value) {
                        'allocated' => $q->whereHas('randomQuestions'),
                        'not_allocated' => $q->whereDoesntHave('randomQuestions'),
                        'configured' => $q->whereNotNull('exam_config'),
                        default => null,
                    };
                }),
                AllowedFilter::callback('applied_from', fn ($q, $v) => $q->whereDate('created_at', '>=', $v)),
                AllowedFilter::callback('applied_to', fn ($q, $v) => $q->whereDate('created_at', '<=', $v)),
                AllowedFilter::callback('search', function ($q, $value) {
                    $value = is_array($value) ? implode(',', $value) : $value;
                    $q->where(fn ($w) => $w->where('name', 'like', "%{$value}%")->orWhere('email', 'like', "%{$value}%")
                        ->orWhere('cnic_number', 'like', "%{$value}%")->orWhere('id', $value));
                }),
            )
            ->allowedSorts('id', 'name', 'created_at', 'batch_no', 'district_of_domicile', 'start_test_time');
    }
}
