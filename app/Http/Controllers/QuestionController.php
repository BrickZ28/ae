<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\QuestionChoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
	public function index()
	{
		return Question::all();
	}

    public function create()
    {
        return view('dashboard.questions.create');
    }

	public function store(Request $request)
	{
        $questionText = $request->input('question'); // Adjust 'question_text' to your actual input name
        $choicesString = $request->input('choices'); // Adjust 'choices' to your actual input name for the comma-separated choices
        $answer = $request->input('answer'); // Adjust 'answer' to your actual input name for the correct answer
        // Save the question
        $question = Question::create(['question' => $questionText]);

        // Extract choices and trim whitespace
        $choices = array_map('trim', explode(',', $choicesString));

        // Save each choice
        foreach ($choices as $choiceText) {
            QuestionChoice::create([
                'question_id' => $question->id, // Use the ID of the question you just saved
                'choice' => $choiceText,
                'is_correct' => $choiceText === $answer // Set the answer to true if the choice matches the correct answer
            ]);
        }

        return redirect()->route('questions.create')->with('success', 'Question created successfully');

//		return Question::create($data);
	}

	public function show(Question $question)
	{
		return $question;
	}

	public function update(Request $request, Question $question)
	{
		$data = $request->validate([
			'question' => ['required'],
		]);

		$question->update($data);

		return $question;
	}

	public function destroy(Question $question)
	{
		$question->delete();

		return response()->json();
	}

    public function randomUserQuestion()
    {
        // Check if user has not had 5 questions today
        $dailyAttemptCount = QuestionAttempt::where('created_at', '>=', now()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay())
            ->where('user_id', auth()->id())
            ->distinct()
            ->count('question_id'); // Count unique question_ids for today

        if ($dailyAttemptCount >= 5) {
            return redirect()->route('dashboard.index')->with('error', 'You have already answered 5 questions today.');
        }

        $attemptedQuestionIdsToday = QuestionAttempt::where('created_at', '>=', now()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay())
            ->where('user_id', auth()->id())
            ->pluck('question_id'); // Get IDs of questions attempted today

        // Check session for previously attempted question ID to return to the same question
        if (session()->has('question_id')) {
            $random_question = Question::findOrFail(session('question_id'));
        } else {
            // Fetch a random question that hasn't been answered by the user today
            $random_question = Question::whereNotIn('id', $attemptedQuestionIdsToday)
                ->inRandomOrder()
                ->with('choices')
                ->first();

            // If all questions have been attempted today, handle accordingly (perhaps notify the user)
            if (!$random_question) {
                return redirect()->route('dashboard.index')->with('error', 'You have attempted all available questions for today.');
            }
        }
        session(['question_start_time' => now()]);
        // Return the question to the view
        return view('dashboard.questions.user-random', compact('random_question'));
    }
}
