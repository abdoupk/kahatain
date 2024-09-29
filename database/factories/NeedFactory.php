<?php

namespace Database\Factories;

use App\Models\Need;
use Illuminate\Database\Eloquent\Factories\Factory;

class NeedFactory extends Factory
{
    protected $model = Need::class;

    public function definition(): array
    {
        $status = ['pending', 'in_progress', 'completed', 'rejected'];

        return [
            'tenant_id' => fake()->uuid,
            'needable_id' => fake()->uuid,
            'needable_type' => fake()->randomElement(['sponsor', 'orphan'])[0],
            'subject' => fake()->sentence(2),
            'demand' => fake('ar_SA')->realText(800),
            'status' => fake()->randomElement($status),
            'note' => fake()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
