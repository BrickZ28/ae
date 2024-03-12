<?php

namespace Database\Factories;

use App\Models\QuestionChoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestionChoiceFactory extends Factory
{
    protected $model = QuestionChoice::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
