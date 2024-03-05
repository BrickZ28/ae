<?php

namespace Database\Seeders;

use App\Models\Screenshot;
use Illuminate\Database\Seeder;

class ScreenshotSeeder extends Seeder
{
	public function run(): void
	{
        Screenshot::factory(10)->create();
	}
}
