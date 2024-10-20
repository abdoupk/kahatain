<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyFactory extends Factory
{
    protected $model = Family::class;

    public function definition(): array
    {
        return [
            'name' => fake('ar_SA')->name,
            'zone_id' => fake()->uuid,
            'address' => fake('ar_SA')->address,
            'location' => [
                'lat' => fake()->latitude(33.67, 33.69),
                'lng' => fake()->longitude(1.011577, 1.016476),
            ],
            'file_number' => fake()->randomNumber(),
            'start_date' => now()->subDays(fake()->numberBetween(1, 10000)),
            'income_rate' => fake()->randomFloat(2, 0, 100),
            'total_income' => fake()->randomFloat(2, 0, 100000),
            'tenant_id' => fake()->uuid,
            'created_by' => User::inRandomOrder()->first()->id,
            'deleted_by' => User::inRandomOrder()->first()->id,
            'created_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'updated_at' => now()->subDays(fake()->numberBetween(0, 35)),
        ];
    }
}
