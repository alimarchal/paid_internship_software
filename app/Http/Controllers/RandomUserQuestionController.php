<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRandomUserQuestionRequest;
use App\Http\Requests\UpdateRandomUserQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\RandomUserQuestion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class RandomUserQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = \Auth::user()->id;
        $user = \Auth::user();

        if ($user->exam_taken == 1) {
            session()->flash('success', 'The testing period has either not commenced or has concluded.');
            return to_route('dashboard');
        }


        if ($user->start_test == 0) {
            session()->flash('error', 'You are not allowed for examination. Please contact administrator.');
            return to_route('dashboard');
        }

        $now = now();
        $startTime = Carbon::parse($user->start_test_time);
        $endTime = Carbon::parse($user->end_test_time);

        if ($now->between($startTime, $endTime)) {
            // Check if questions have already been allocated to this user
            $allocatedQuestionsExist = RandomUserQuestion::where('user_id', $user_id)->exists();

            if (!$allocatedQuestionsExist) {
                try {
                    DB::transaction(function () use ($user_id) {
//                        // Fetch all questions
//                        $allQuestions = Question::all();
//
//                        $english_questions = Question::where('category_id', 4)->get();
//                        $general_knowledge_questions = Question::where('category_id', 7)->get();
//                        $other_questions = Question::whereNotIn('category_id', [4, 7])->get();
//
//                        $english_question_total = 15;
//                        $general_knowledge_question_total = 15;
//                        $others_question_total = 15;
//
//                        $randomQuestions = collect();
//
//                        // Ensure unique selection of 5 questions
//                        while ($randomQuestions->count() < 100) {
//                            // Attempt to add a randomly selected question
//                            $randomQuestion = $allQuestions->random();
//
//                            // Check if this question has already been selected, if not, add it to the collection
//                            if (!$randomQuestions->contains('id', $randomQuestion->id)) {
//                                $randomQuestions->push($randomQuestion);
//                            }
//                        }

                        // Fetch questions by category with the specified amounts
                        $english_questions = Question::where('category_id', 4)->inRandomOrder()->take(10)->get();
                        $general_knowledge_questions = Question::where('category_id', 7)->inRandomOrder()->take(10)->get();
                        // Assuming 'other' categories mean every category except for English and General Knowledge
                        $other_questions = Question::whereNotIn('category_id', [4, 7, 14])->inRandomOrder()->take(80)->get();

                        // Merge the collections into one
                        $randomQuestions = $english_questions->merge($general_knowledge_questions)->merge($other_questions);

                        // Optional: If you want the final collection to be shuffled
                        $randomQuestions = $randomQuestions->shuffle();


                        // Store the randomly selected questions for this user
                        foreach ($randomQuestions as $question) {
                            RandomUserQuestion::create([
                                'user_id' => $user_id,
                                'question_id' => $question->id,
                            ]);
                        }
                    });
                } catch (\Exception $e) {
                    // Handle the exception and rollback the transaction
                    DB::rollBack();
                    // Optionally, you can log the error or return an error response
                    return back()->withErrors(['error' => 'An error occurred while allocating questions.']);
                }
            }

            // Here's how you get the current page number with a default of 1 if there's no 'page' query parameter.
            $currentPage = request()->input('page', 1);

            $totalQuestions = RandomUserQuestion::where('user_id', $user_id)->count();
            $user_aloted_questions = RandomUserQuestion::where('user_id', $user_id)->paginate(1);
            $currentQuestionNumber = $user_aloted_questions->currentPage();

            $user->start_test = 1;
            $user->save();
            // Proceed to the view
            return view('questions.index', compact('user_aloted_questions', 'user', 'totalQuestions', 'currentQuestionNumber'));
        }
        else {
            // Navigate back with a notification of timing constraints
            return to_route('dashboard')->withErrors(['error' => 'The testing period has either not commenced or has concluded.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function password_change(User $user)
    {
        return view('questions.edit', compact('user'));
    }


    public function password_change_update(Request $request, User $user)
    {
        if ($request->cpr == "Yes") {
            $user->password = Hash::make($request->password);
        }

        $user->start_test = 1;
        $user->start_test_time = $request->start_test_time;
        $user->end_test_time = $request->end_test_time;
        $user->save();
        session()->flash('success', 'User password has been change and test started...');
        return to_route('candidate.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRandomUserQuestionRequest $request)
    {
        $user_id = \Auth::user()->id;
        $user = \Auth::user();
        $now = now();
        $startTime = Carbon::parse($user->start_test_time);
        $endTime = Carbon::parse($user->end_test_time);

        if ($now->between($startTime, $endTime)) {
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
        else {
            // Navigate back with a notification of timing constraints
            return to_route('dashboard')->withErrors(['error' => 'The testing time has concluded.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function finishExam(\Illuminate\Http\Request $request)
    {
        $user_id = \Auth::user()->id;
        $user = \Auth::user();
        $user->exam_taken = 1;
        $user->start_test = 1;
        $user->save();
        session()->flash('success', 'Your exam has been finished successfully.');
        return to_route('dashboard');
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
