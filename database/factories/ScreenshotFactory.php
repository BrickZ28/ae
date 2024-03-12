<?php

namespace Database\Factories;

use App\Models\Screenshot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScreenshotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'path' => fake()->imageUrl,
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'created_by' => User::all()->random()->id,
            'uploaded_by' => User::all()->random()->id,
        ];
    }
}
