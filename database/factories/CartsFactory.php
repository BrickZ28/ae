<?php

namespace Database\Factories;

use App\Models\Carts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CartsFactory extends Factory
{
	protected $model = Carts::class;

	public function definition(): array
	{
		return [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
		];
	}
}
