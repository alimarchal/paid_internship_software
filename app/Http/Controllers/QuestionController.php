<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\RandomUserQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = Question::with(['category', 'answers'])
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('search'), fn ($q) => $q->where('text', 'like', '%'.$request->search.'%'))
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('settings.questions.index', [
            'questions' => $questions,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('settings.questions.form', [
            'question' => new Question(),
            'categories' => Category::orderBy('name')->get(),
            'answers' => collect(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $rows = $this->answerRows($request);

        DB::transaction(function () use ($data, $rows) {
            $question = Question::create($data);
            foreach ($rows as $row) {
                $question->answers()->create(['text' => $row['text'], 'is_correct' => $row['is_correct']]);
            }
        });

        return to_route('settings.questions.index')->with('success', 'Question added.');
    }

    public function show(Question $question)
    {
        $question->load(['category', 'answers']);
        $used = RandomUserQuestion::where('question_id', $question->id)->count();

        return view('settings.questions.show', compact('question', 'used'));
    }

    public function edit(Question $question)
    {
        return view('settings.questions.form', [
            'question' => $question,
            'categories' => Category::orderBy('name')->get(),
            'answers' => $question->answers()->orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $data = $this->validated($request);
        $rows = $this->answerRows($request);

        $keepIds = collect($rows)->pluck('id')->filter()->all();
        $removed = $question->answers()->whereNotIn('id', $keepIds)->pluck('id');
        $inUse = RandomUserQuestion::whereIn('answer_id', $removed)->exists();
        if ($inUse) {
            throw ValidationException::withMessages(['answers' => 'An answer you removed was already chosen by a candidate, so it cannot be deleted. Keep it or just edit its text.']);
        }

        DB::transaction(function () use ($question, $data, $rows, $removed) {
            $question->update($data);
            Answer::whereIn('id', $removed)->delete();

            foreach ($rows as $row) {
                if ($row['id']) {
                    $question->answers()->whereKey($row['id'])->update(['text' => $row['text'], 'is_correct' => $row['is_correct']]);
                } else {
                    $question->answers()->create(['text' => $row['text'], 'is_correct' => $row['is_correct']]);
                }
            }
        });

        return to_route('settings.questions.show', $question)->with('success', 'Question updated.');
    }

    public function destroy(Question $question)
    {
        if (RandomUserQuestion::where('question_id', $question->id)->exists()) {
            return back()->with('error', 'This question is already part of candidates\' papers, so it cannot be deleted.');
        }

        DB::transaction(function () use ($question) {
            $question->answers()->delete();
            $question->delete();
        });

        return to_route('settings.questions.index')->with('success', 'Question deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'text' => ['required', 'string'],
            'difficulty' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * Non-empty answer rows from the form. Exactly one must be marked correct.
     *
     * @return array<int, array{id: ?int, text: string, is_correct: bool}>
     */
    private function answerRows(Request $request): array
    {
        $request->validate([
            'answers' => ['required', 'array'],
            'answers.*.text' => ['nullable', 'string'],
            'answers.*.id' => ['nullable', 'integer'],
            'correct' => ['required'],
        ], ['correct.required' => 'Select the correct answer.']);

        $rows = [];
        foreach ($request->input('answers') as $key => $answer) {
            $text = trim($answer['text'] ?? '');
            if ($text === '') {
                continue;
            }
            $rows[] = [
                'id' => !empty($answer['id']) ? (int) $answer['id'] : null,
                'text' => $text,
                'is_correct' => (string) $key === (string) $request->input('correct'),
            ];
        }

        if (count($rows) < 2) {
            throw ValidationException::withMessages(['answers' => 'Enter at least two answers.']);
        }
        if (collect($rows)->where('is_correct', true)->count() !== 1) {
            throw ValidationException::withMessages(['correct' => 'The correct answer must be one of the filled answers.']);
        }

        return $rows;
    }
}
