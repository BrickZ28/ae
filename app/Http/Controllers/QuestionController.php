<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionChoice;
use App\Services\TriviaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    protected $triviaService;

    public function __construct(TriviaService $triviaService)
    {
        $this->triviaService = $triviaService;
    }

    public function index()
    {
        $questions = Question::all();
        $filters = ['id', 'question', 'created on', 'updated on', 'view', 'edit', 'delete'];

        return view('dashboard.questions.index', compact('questions', 'filters'));
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

    public function edit(Question $question)
    {
        return view('dashboard.questions.edit', compact('question'));
    }

    public function show(Question $question)
    {
        return $question;
    }

    public function update(Request $request, $questionId)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255', // Ensure the question text is required and validated
            'choices' => 'required|array',
            'choices.*.id' => 'required|exists:question_choices,id', // Validate choice IDs exist
            'choices.*.text' => 'required|string|max:255', // Validate choice texts
            'correct_answer' => 'required|integer|exists:question_choices,id',
        ]);

        DB::transaction(function () use ($validatedData, $questionId, $request) {
            // Update the question text
            $question = Question::findOrFail($questionId);
            $question->update(['question' => $validatedData['question']]);

            // Iterate over the choices and update each
            foreach ($request->choices as $choiceData) {
                $choice = QuestionChoice::findOrFail($choiceData['id']);
                $choice->choice = $choiceData['text'];
                $choice->is_correct = ($choiceData['id'] == $request->correct_answer);
                $choice->save();
            }
        });

        return redirect()->route('questions.index')->with('success', 'Question and choices updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('dashboard.index')->with('success', 'Question deleted successfully');
    }

    public function randomUserQuestion()
    {
        return $this->triviaService->getRandomUserQuestion();
    }
}
