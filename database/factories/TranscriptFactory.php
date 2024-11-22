<?php

namespace Database\Factories;

use App\Models\Transcript;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TranscriptFactory extends Factory
{
    protected $model = Transcript::class;

    public function definition(): array
    {
        return [
            'trimester' => fake()->randomElement(['first', 'second', 'third']),
            'average' => fake()->randomFloat(3, 18),
            'orphan_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
