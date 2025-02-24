<?php

namespace Database\Factories;

use App\Models\Competence;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetenceFactory extends Factory
{
    protected $model = Competence::class;

    public function definition(): array
    {
        return [
            'tenant_id' => fake()->uuid,
            'name' => fake('ar_SA')->word,
        ];
    }
}
