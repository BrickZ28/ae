<?php

namespace Database\Factories;

use App\Models\CartItems;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CartItemsFactory extends Factory
{
	protected $model = CartItems::class;

	public function definition(): array
	{
		return [
			'created_at' => Carbon::now(),
			'updated_at' => Carbon::now(),
			'quantity' => $this->faker->randomNumber(),
		];
	}
}
