<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZoneFactory extends Factory
{
    protected $model = Zone::class;

    public function definition(): array
    {
        return [
            'name' => ' منطقة رقم '.fake()->numberBetween(1, 20),
            'description' => fake('ar_SA')->realText(1000),
            'created_at' => now(),
            'tenant_id' => fake()->uuid,
            'created_by' => User::inRandomOrder()->first()->id,
            'deleted_by' => User::inRandomOrder()->first()->id,
            'updated_at' => now(),
        ];
    }
}
