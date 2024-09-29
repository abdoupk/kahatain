<?php

namespace Database\Factories;

use App\Models\Housing;
use Illuminate\Database\Eloquent\Factories\Factory;

class HousingFactory extends Factory
{
    protected $model = Housing::class;

    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['independent', 'with_family', 'tenant', 'inheritance', 'other']),
            'value' => fake()->word,
            'housing_receipt_number' => fake()->regexify('[1-9][0-9]{8}'),
            'number_of_rooms' => fake()->numberBetween(1, 3),
            'other_properties' => fake('ar_SA')->realText(500),
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
        ];
    }
}
