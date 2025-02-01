<?php

namespace Database\Factories;

use App\Models\MonthlyBasket;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyBasketFactory extends Factory
{
    protected $model = MonthlyBasket::class;

    public function definition(): array
    {
        return [
            'qty_for_family' => fake()->numberBetween(1, 5),
            'status' => fake()->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
            'tenant_id' => fake()->uuid,
            'inventory_id' => fake()->uuid,
        ];
    }
}
