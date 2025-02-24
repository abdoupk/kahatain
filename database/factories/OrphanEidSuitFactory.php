<?php

namespace Database\Factories;

use App\Models\OrphanEidSuit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrphanEidSuitFactory extends Factory
{
    protected $model = OrphanEidSuit::class;

    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->words(), //
            'orphan_id' => $this->faker->word(),
            'note' => $this->faker->word(),
            'clothes_shop_name' => $this->faker->name(),
            'clothes_shop_phone_number' => $this->faker->phoneNumber(),
            'shoes_shop_name' => $this->faker->name(),
            'shoes_shop_phone_number' => $this->faker->phoneNumber(),
            'user_id' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
