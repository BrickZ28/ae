<?php

namespace Database\Factories;

use App\Models\QuestionAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestionAttemptFactory extends Factory
{
	protected $model = QuestionAttempt::class;

	public function definition(): array
	{
		return [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}
}
