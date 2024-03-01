<?php
namespace App\Services;

use App\Models\Question;
use App\Models\QuestionAttempt;
use App\Models\QuestionChoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TriviaService
{
    public function storeQuestion($questionText, $choicesString, $answer)
    {
        DB::transaction(function () use ($questionText, $choicesString, $answer) {
            $question = Question::create(['question' => $questionText]);
            $choices = array_map('trim', explode(',', $choicesString));

            foreach ($choices as $choiceText) {
                QuestionChoice::create([
                    'question_id' => $question->id,
                    'choice' => $choiceText,
                    'is_correct' => $choiceText === $answer
                ]);
            }
        });

        return redirect()->route('questions.create')->with('success', 'Question created successfully');
    }

    public function getRandomUserQuestion()
    {
        $dailyAttemptCount = QuestionAttempt::where('created_at', '>=', now()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay())
            ->where('user_id', Auth::id())
            ->distinct()
            ->count('question_id');

        if ($dailyAttemptCount >= 5) {
            return redirect()->route('dashboard.index')->with('error', 'You have already answered 5 questions today.');
        }

        $attemptedQuestionIdsToday = QuestionAttempt::where('created_at', '>=', now()->startOfDay())
            ->where('created_at', '<=', now()->endOfDay())
            ->where('user_id', Auth::id())
            ->pluck('question_id');

        $random_question = Question::whereNotIn('id', $attemptedQuestionIdsToday)
            ->inRandomOrder()
            ->with('choices')
            ->first();

        if (!$random_question) {
            // Redirect to dashboard with an error message if no questions are left for the day
            return redirect()->route('dashboard.index')->with('error', 'You have attempted all available questions for today.');
        }

        Session::put(['question_start_time' => now()]);
        return view('dashboard.questions.user-random', compact('random_question'));
    }


    public function attemptUserQuestion($questionId, $selectedChoiceId)
    {
        $user = Auth::user();
        $question = Question::findOrFail($questionId);
        $choice = $question->choices()->findOrFail($selectedChoiceId);

        $timedOutResponse = $this->timedOut($questionId, $selectedChoiceId);
        if ($timedOutResponse) {
            // If timedOut method returns a response, return it immediately,
            // halting further processing since it's a redirect due to timeout
            return $timedOutResponse;
        }

        $isCorrect = $choice->is_correct;
        $attemptCount = $question->attempts()->where('user_id', $user->id)->count() + 1;
        $attempts_left = 4 - $attemptCount;
        $credits = 0;

        if ($isCorrect) {
            $credits = $this->calculateCredits($attemptCount);
        }

        $user->increment('ae_credits', $credits);

        QuestionAttempt::create([
            'user_id' => $user->id,
            'question_id' => $questionId, // Add this line to include the question ID
            'choice_id' => $selectedChoiceId,
            'is_correct' => $isCorrect,
        ]);

        if ($isCorrect) {
            return redirect(route('dashboard.index'))->with('success', "You got it right! Credits awarded: {$credits}");
        } else {
            return back()->with('error', "Attempt number {$attemptCount} recorded, {$attempts_left} attempts left. Incorrect answer.")
                ->with('question_id', $questionId);
        }
    }

    private function timedOut($questionId, $selectedChoiceId)
    {
        $startTime = Session::get('question_start_time');
        $elapsed = now()->diffInSeconds($startTime);
        $timeLimit = 120; // 2 minutes

        if ($elapsed > $timeLimit) {
            QuestionAttempt::create([
                'user_id' => Auth::id(),
                'question_id' => $questionId,
                'choice_id' => $selectedChoiceId,
                'is_correct' => false,
            ]);

            // Ensure to properly return a redirect response with the timeout error message
            return redirect()->route('dashboard.index')->with('error', 'Time limit exceeded. Your attempt has been recorded as incorrect.');
        }

        // If not timed out, you might want to continue with the attempt processing
        // But ensure this method returns false or null if no timeout, so caller knows to proceed
        return false;
    }

    private function calculateCredits($attemptCount)
    {
        switch ($attemptCount) {
            case 1:
                return 10;
            case 2:
                return 5;
            case 3:
                return 1;
            default:
                return 0;
        }
    }
}
