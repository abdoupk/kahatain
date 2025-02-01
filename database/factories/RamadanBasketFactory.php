<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\RamadanBasket;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RamadanBasketFactory extends Factory
{
    protected $model = RamadanBasket::class;

    public function definition(): array
    {
        return [
            'qty_for_family' => fake('ar_SA')->numberBetween(1, 5),
            'status' => fake('ar_SA')->boolean(60),
            'inventory_id' => Inventory::inRandomOrder()->first()->id,
            'tenant_id' => Tenant::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
