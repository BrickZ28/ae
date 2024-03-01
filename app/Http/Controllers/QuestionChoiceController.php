<?php

namespace App\Http\Controllers;

use App\Models\QuestionChoice;
use Illuminate\Http\Request;

class QuestionChoiceController extends Controller
{
	public function index()
	{
		return QuestionChoice::all();
	}

	public function store(Request $request)
	{
		$data = $request->validate([

		]);

		return QuestionChoice::create($data);
	}

	public function show(QuestionChoice $questionChoice)
	{
		return $questionChoice;
	}

	public function update(Request $request, QuestionChoice $questionChoice)
	{
		$data = $request->validate([

		]);

		$questionChoice->update($data);

		return $questionChoice;
	}

	public function destroy(QuestionChoice $questionChoice)
	{
		$questionChoice->delete();

		return response()->json();
	}
}
