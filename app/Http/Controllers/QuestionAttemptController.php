<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\QuestionChoice;
use Illuminate\Http\Request;

class QuestionAttemptController extends Controller
{

    public function attemptUserQuestion($questionId, Request $request)
    {
        $startTime = session('question_start_time');
        $timeLimit = 120; // 2 minutes in seconds
        $elapsed = now()->diffInSeconds($startTime);

        if ($elapsed > $timeLimit) {
            // Handle expired time, e.g., invalidate the submission
            return back()->with('error', 'Time limit exceeded.');
        }

        $user = auth()->user(); // Assuming you're using Laravel's authentication
        $question = Question::findOrFail($questionId);
        $selectedChoiceId = $request->input('choice');

        // Validate the selected choice belongs to the question
        $choice = $question->choices()->findOrFail($selectedChoiceId);


        // Determine if the choice is correct
        $isCorrect = $choice->is_correct; // Assuming you have an `is_correct` field

        // Check previous attempts for this question by the user
        $attemptCount = $question->attempts()->where('user_id', $user->id)->count();

        // Increment attempt count
        $attemptCount++;
        $attempts_left = 4 - $attemptCount;


        // Award credits based on attempt count and correctness
        $credits = 0;
        if ($isCorrect) {
            if ($attemptCount == 1) {
                $credits = 10;
            } elseif ($attemptCount == 2) {
                $credits = 5;
            } elseif ($attemptCount == 3) {
                $credits = 1;
            }
        }

        // Update user's credits (assuming you have a column `ae_credits` in your `users` table)
        $user->increment('ae_credits', $credits);

        // Save the attempt
        $question->attempts()->create([
            'user_id' => $user->id,
            'choice_id' => $selectedChoiceId,
            'is_correct' => $isCorrect,
        ]);

        // Redirect with a message
        if ($isCorrect) {
            return redirect(route('questions.user.random'))->with('success', 'You got it right! Credits awarded: ' . $credits);
        } elseif ($attemptCount <= 4) {
            return back()->with('error', "Attempt number {$attemptCount} recorded, {$attempts_left} attempts left. Incorrect answer.")
                ->with('question_id', $questionId); // Assuming $questionId is available in this scope
        } else {
            return redirect(route('dashboard.index'))->with('error', 'Incorrect answer. No more attempts left.');
        }
    }



}
