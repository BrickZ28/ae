<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PackageFactory extends Factory
{
	protected $model = Package::class;

	public function definition(): array
	{
		return [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
			'name' => $this->faker->name(),
			'description' => $this->faker->text(),
			'price' => $this->faker->randomFloat(),
		];
	}
}
