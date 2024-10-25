<?php

namespace Database\Factories;

use App\Models\Committee;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommitteeFactory extends Factory
{
    protected $model = Committee::class;

    public function definition(): array
    {
        return [
            'name' => fake('ar_SA')->name,
            'description' => fake('ar_SA')->realText(500),
            'tenant_id' => fake()->uuid,
            'created_by' => fake()->uuid,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
