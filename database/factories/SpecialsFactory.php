<?php

namespace Database\Factories;

use App\Models\Specials;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SpecialsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'discount' => $this->faker->randomFloat(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'usuage_limit' => $this->faker->randomNumber(),
            'active' => $this->faker->boolean(),
        ];
    }
}
