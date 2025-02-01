<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\MonthlyBasket;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyBasketFactory extends Factory
{
    protected $model = MonthlyBasket::class;

    public function definition(): array
    {
        return [
            'qty_for_family' => fake('ar_SA')->numberBetween(1, 5),
            'status' => fake('ar_SA')->boolean(),
            'created_at' => now(),
            'updated_at' => now(),

            'tenant_id' => Tenant::inRandomOrder()->first()->id,
            'inventory_id' => Inventory::inRandomOrder()->first()->id,
            'created_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
