<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRandomUserQuestionRequest;
use App\Http\Requests\UpdateRandomUserQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\RandomUserQuestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RandomUserQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = \Auth::user()->id;

        // Check if questions have already been allocated to this user
        $allocatedQuestionsExist = RandomUserQuestion::where('user_id', $user_id)->exists();

        if (!$allocatedQuestionsExist) {
            // Fetch all questions
            $allQuestions = Question::all();

            $randomQuestions = collect();

            // Ensure unique selection of 5 questions
            while ($randomQuestions->count() < 5) {
                // Attempt to add a randomly selected question
                $randomQuestion = $allQuestions->random();

                // Check if this question has already been selected, if not, add it to the collection
                if (!$randomQuestions->contains('id', $randomQuestion->id)) {
                    $randomQuestions->push($randomQuestion);
                }
            }

            // Store the randomly selected questions for this user
            foreach ($randomQuestions as $question) {
                RandomUserQuestion::create([
                    'user_id' => $user_id,
                    'question_id' => $question->id,
                ]);
            }
        }
        $user_aloted_questions = RandomUserQuestion::where('user_id', $user_id)->simplePaginate(1);

        // Proceed to the view
        return view('questions.index', compact('user_aloted_questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRandomUserQuestionRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            $question_id = $request->question_id;
            $answer_id = $request->answer_id;

            // Optimize by using firstOrFail to automatically throw an exception if not found
            $random_question = RandomUserQuestion::where('user_id', $user->id)->where('question_id', $question_id)->firstOrFail();

            $random_question->answer_id = $answer_id;
            $random_question->is_answered = true;

            // Use a more efficient query to check if the answer is correct
            $answer = Answer::where('question_id', $question_id)->where('is_correct', 1)->first();
            $is_correct = $answer_id == $answer->id ? 1 : 0;

            $random_question->is_correct = $is_correct;
            $random_question->timestamp = Carbon::now();
            $random_question->save();

            DB::commit(); // Commit the transaction if everything's successful

            session()->flash('success', 'Your answer has been saved successfully.');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction on any error

            // Optionally, log the error or handle it as needed
            // Log::error($e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'Unable to save your answer. Please try again.']);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(RandomUserQuestion $randomUserQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RandomUserQuestion $randomUserQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRandomUserQuestionRequest $request, RandomUserQuestion $randomUserQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RandomUserQuestion $randomUserQuestion)
    {
        //
    }
}
