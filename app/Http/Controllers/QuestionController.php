<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TriviaService;

class QuestionController extends Controller
{
    protected $triviaService;

    public function __construct(TriviaService $triviaService)
    {
        $this->triviaService = $triviaService;
    }

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
        $questionText = $request->input('question');
        $choicesString = $request->input('choices');
        $answer = $request->input('answer');

        $this->triviaService->storeQuestion($questionText, $choicesString, $answer);

        return redirect()->route('questions.create')->with('success', 'Question created successfully');
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

        return response()->json(null, 204); // No content
    }

    public function randomUserQuestion()
    {
        return $this->triviaService->getRandomUserQuestion();
    }
}
