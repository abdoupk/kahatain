<?php

namespace Database\Factories;

use App\Models\RamadanBasket;
use Illuminate\Database\Eloquent\Factories\Factory;

class RamadanBasketFactory extends Factory
{
    protected $model = RamadanBasket::class;

    public function definition(): array
    {
        return [
            'qty_for_family' => fake()->numberBetween(1, 5),
            'status' => fake()->boolean(60),
            'inventory_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
