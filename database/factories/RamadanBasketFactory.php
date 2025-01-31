<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\RamadanBasket;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RamadanBasketFactory extends Factory
{
    protected $model = RamadanBasket::class;

    public function definition(): array
    {
        return [
            'qty_for_family' => $this->faker->word(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'inventory_id' => Inventory::factory(),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
