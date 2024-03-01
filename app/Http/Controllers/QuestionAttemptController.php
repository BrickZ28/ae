<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TriviaService;

class QuestionAttemptController extends Controller
{
    protected $triviaService;

    public function __construct(TriviaService $triviaService)
    {
        $this->triviaService = $triviaService;
    }

    public function attemptUserQuestion($questionId, Request $request)
    {
        $selectedChoiceId = $request->input('choice');
        return $this->triviaService->attemptUserQuestion($questionId, $selectedChoiceId);
    }
}
