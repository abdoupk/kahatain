<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition(): array
    {
        $incomes = [
            'cnr' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
            'cnas' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
            'casnos' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
            'pension' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
            'account' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
            'other_income' => fake()->randomElement([fake()->numberBetween(1000, 5000), null]),
        ];

        return [
            ...$incomes,
            'total_income' => array_reduce($incomes, function ($carry, $item) {
                return $carry + $item;
            }, 0),
            'sponsor_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
        ];
    }
}
