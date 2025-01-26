<?php

namespace Database\Factories;

use App\Models\Income;
use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition(): array
    {
        $incomes = [
            'cnr' => fake()->boolean(13),
            'cnas' => fake()->boolean(13),
            'casnos' => fake()->boolean(13),
            'pension' => fake()->boolean(13),
            'account' => [
                'ccp' => [
                    'monthly_income' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
                    'balance' => fake()->randomElement([fake()->numberBetween(1000, 5000), 0]),
                    'performance_grant' => fake()->randomElement([fake()->numberBetween(1000, 5000), 0]),
                ],
                'bank' => [
                    'monthly_income' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
                    'balance' => fake()->randomElement([fake()->numberBetween(1000, 5000), 0]),
                    'performance_grant' => fake()->randomElement([fake()->numberBetween(1000, 5000), 0]),
                ],
            ],
            'other_income' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
        ];

        return [
            ...$incomes,
            'total_income' => setTotalIncomeAttribute($incomes, Sponsor::inRandomOrder()->first()),
            'sponsor_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
        ];
    }
}
