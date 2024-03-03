<?php

namespace App\Services;

use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\QuestionChoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TriviaService
{
    /**
     * Store a new question along with its choices.
     */
    public function storeQuestion($questionText, $choicesString, $answer)
    {
        DB::transaction(function () use ($questionText, $choicesString, $answer) {
            $question = Question::create(['question' => $questionText]);
            $choicesString = rtrim($choicesString, ' ^');
            $choices = array_map('trim', explode('^', $choicesString));

            foreach ($choices as $choiceText) {
                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice' => $choiceText,
                    'is_correct' => ($choiceText === $answer),
                ]);
            }
        });

        return redirect()->route('questions.create')->with('success', 'Question created successfully');
    }

    /**
     * Get a random question for the user, ensuring it's not one they've already attempted today.
     */
    public function getRandomUserQuestion()
    {
        $attemptedQuestionIdsToday = QuestionAttempt::where('created_at', '>=', now()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay())
            ->where('user_id', Auth::id())
            ->pluck('question_id');

        // Check if we're retrying a question
        $retryQuestionId = session('question_id');
        if ($retryQuestionId) {
            $random_question = Question::where('id', $retryQuestionId)->with('choices')->first();
        } else {
            $random_question = Question::whereNotIn('id', $attemptedQuestionIdsToday)
                ->inRandomOrder()
                ->with('choices')
                ->first();

            // Only generate a new token if we're fetching a new question
            Session::put('attempt_token', Str::random(40));
        }

        if (!$random_question) {
            return redirect()->route('dashboard.index')->with('error', 'You have attempted all available questions for today.');
        }

        Session::put(['question_start_time' => now()]);

        // Pass both the question and the existing/new token to the view
        $attempt_token = session('attempt_token');
        return view('dashboard.questions.user-random', compact('random_question', 'attempt_token'));
    }


    /**
     * Handle a user's attempt to answer a question, checking for correctness and whether the attempt is valid (e.g., not expired).
     */
    public function attemptUserQuestion($questionId, $selectedChoiceId)
    {
        $user = Auth::user();
        $question = Question::findOrFail($questionId);
        $choice = $question->choices()->findOrFail($selectedChoiceId);

        // Check for timeout first
        if ($this->timedOut()) {
            Session::forget('attempt_token'); // Clear attempt token on timeout
            return redirect()->route('dashboard.index')->with('error', 'Time limit exceeded. Your attempt has been recorded as incorrect.');
        }

        // Then validate the attempt token
        if (!$this->isValidAttempt()) {
            Session::forget('attempt_token'); // Clear attempt token if invalid
            return redirect()->route('dashboard.index')->with('error', 'This attempt is no longer valid.');
        }

        $isCorrect = $choice->is_correct;
        $attemptCount = $question->attempts()->where('user_id', $user->id)->count();

        // Record the attempt
        QuestionAttempt::create([
            'user_id' => $user->id,
            'question_id' => $questionId,
            'choice_id' => $selectedChoiceId,
            'is_correct' => $isCorrect,
        ]);

        // Always refresh the attempt token after processing to prepare for the next question or retry
        Session::put('attempt_token', Str::random(40));

        if ($isCorrect) {
            $credits = $this->calculateCredits($attemptCount + 1);
            $user->increment('ae_credits', $credits);

            // After a correct answer, redirect to the dashboard (or next question) and clear the question_id from the session
            Session::forget('question_id');
            return redirect(route('dashboard.index'))->with('success', "You got it right! Credits awarded: {$credits}");
        } else {
            // If the answer is incorrect, allow retrying the same question without changing the attempt token
            // 'question_id' remains in the session for retry
            return back()->with('error', "Attempt number " . ($attemptCount + 1) . " recorded. Incorrect answer.")
                ->with('question_id', $questionId);
        }
    }



    /**
     * Check if the current attempt has timed out.
     */
    private function timedOut()
    {
        $startTime = Session::get('question_start_time');
        return now()->diffInSeconds($startTime) > 120;
    }

    /**
     * Validate the attempt token.
     */
    private function isValidAttempt()
    {
        $attemptToken = Session::get('attempt_token');
        $providedToken = request()->input('attempt_token');
        return $attemptToken && $attemptToken === $providedToken;
    }

    /**
     * Calculate credits based on the attempt count.
     */
    private function calculateCredits($attemptCount)
    {
        switch ($attemptCount) {
            case 1: return 10;
            case 2: return 5;
            case 3: return 1;
            default: return 0;
        }
    }
}
