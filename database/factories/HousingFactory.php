<?php

namespace Database\Factories;

use App\Models\Housing;
use Illuminate\Database\Eloquent\Factories\Factory;

class HousingFactory extends Factory
{
    protected $model = Housing::class;

    public function definition(): array
    {
        $name = fake()->randomElement(['independent', 'with_family', 'tenant', 'inheritance', 'other']);
        $value = $name === 'tenant' ? fake()->numberBetween(3000, 15000) : fake()->sentence();

        return [
            'name' => $name,
            'value' => $value,
            'housing_receipt_number' => fake()->regexify('[1-9][0-9]{8}'),
            'number_of_rooms' => fake()->numberBetween(1, 3),
            'other_properties' => fake('ar_SA')->realText(500),
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
        ];
    }
}
