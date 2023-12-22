<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'global_name' => fake()->userName(),
            'discriminator' => fake()->randomDigit(),
            'profile_photo_path' => fake()->imageUrl(),
            'avatar' => fake()->imageUrl(),
            'verified' => fake()->boolean(),
            'banner' => fake()->uuid(),
            'banner_color' => fake()->hexColor(),
            'accent_color' => fake()->hexColor(),
            'locale' => fake()->locale(),
            'mfa_enabled' => fake()->boolean(),
            'premium_type' => fake()->semver(),
            'public_flags' => fake()->imageUrl(),
            'last_login_at' => fake()->dateTime(),
            'last_login_ip' => fake()->ipv6(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
