<?php

namespace Database\Factories;

use App\Models\Family;
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
            'difference_before_monthly_sponsorship' => fake()->randomFloat(2, 0, 10000),
            'difference_after_monthly_sponsorship' => fake()->randomFloat(2, 0, 10000),
            'amount_from_association' => fake()->randomFloat(2, 0, 10000),
            'monthly_sponsorship_rate' => fake()->randomFloat(2, 0, 10000),
            'tenant_id' => fake()->uuid,
            'created_by' => fake()->uuid(),
            'created_at' => now()->subDays(fake()->numberBetween(0, 350)),
            'updated_at' => now()->subDays(fake()->numberBetween(0, 350)),
        ];
    }
}
