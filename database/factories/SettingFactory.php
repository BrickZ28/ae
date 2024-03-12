<?php

namespace Database\Factories;

use App\Models\Server;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SettingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'setting' => fake()->sentence(),
            'server_id' => Server::all()->random()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
