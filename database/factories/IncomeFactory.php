<?php

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition(): array
    {
        return [
            'cnr' => fake()->numberBetween(10000, 20000),
            'cnas' => fake()->numberBetween(10000, 20000),
            'casnos' => fake()->numberBetween(10000, 20000),
            'pension' => fake()->numberBetween(10000, 20000),
            'account' => fake()->numberBetween(10000, 20000),
            'other_income' => fake()->numberBetween(10000, 20000),
            'total_income' => fake()->numberBetween(10000, 20000),
            'sponsor_id' => fake()->numberBetween(10000, 20000),
            'tenant_id' => fake()->uuid,
        ];
    }
}
