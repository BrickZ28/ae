<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Rule;
use App\Models\Screenshot;
use App\Models\Server;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Screenshot::factory(5), 'uploadedscreenshots')
            ->has(Screenshot::factory(2), 'createdscreenshots')
            ->create();
        Rule::factory(5)->create();
        Server::factory(10)
            ->has(Setting::factory(5), 'settings')
            ->create();

    }
}
