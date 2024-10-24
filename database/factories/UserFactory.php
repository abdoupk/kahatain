<?php

namespace Database\Factories;

use App\Models\AcademicLevel;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
            'first_name' => fake('ar_SA')->firstName,
            'last_name' => fake('ar_SA')->lastName,
            'phone' => fake()->regexify('(06|07|05)[0-9]{8}'),
            'email' => fake()->unique()->safeEmail,
            'zone_id' => Zone::inRandomOrder()->first()?->id,
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake('ar_SA')->address,
            'workplace' => fake('ar_SA')->realText(50),
            'location' => [
                'lat' => fake()->latitude(33.67, 33.69),
                'lng' => fake()->longitude(1.011577, 1.016476),
            ],
            'function' => fake('ar_SA')->realText(50),
            'academic_level_id' => AcademicLevel::inRandomOrder()->first()?->id,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'qualification' => fake('ar_SA')->word,
            'created_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'updated_at' => now()->subDays(fake()->numberBetween(0, 35)),
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
