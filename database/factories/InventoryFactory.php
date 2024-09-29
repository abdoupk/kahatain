<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    public function definition(): array
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => fake()->uuid,
            'deleted_by' => fake()->uuid,
            'name' => fake()->name(),
            'type' => fake()->randomElement(['diapers', 'baby_milk', null]),
            'qty_for_family' => fake()->numberBetween(1, 5),
            'qty' => fake()->numberBetween(1, 1000),
            'unit' => fake()->randomElement(['kg', 'liter', 'piece']),
            'tenant_id' => fake()->words(),
            'note' => fake()->realText(600),
        ];
    }
}
