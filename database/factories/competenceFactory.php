<?php

namespace Database\Factories;

use App\Models\competence;
use Illuminate\Database\Eloquent\Factories\Factory;

class competenceFactory extends Factory
{
    protected $model = competence::class;

    public function definition(): array
    {
        return [
            'tenant_id' => fake()->uuid,
            'name' => fake('ar_SA')->word,
        ];
    }
}
