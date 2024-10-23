<?php

namespace Database\Factories;

use App\Models\Benefactor;
use Illuminate\Database\Eloquent\Factories\Factory;

class BenefactorFactory extends Factory
{
    protected $model = Benefactor::class;

    public function definition(): array
    {
        return [
            'first_name' => fake('ar_SA')->firstName,
            'last_name' => fake('ar_SA')->lastName,
            'phone' => fake()->regexify('(06|07|05)[0-9]{8}'),
            'address' => fake('ar_SA')->address,
            'location' => [
                'lat' => fake()->latitude(33.67, 33.69),
                'lng' => fake()->longitude(1.011577, 1.016476),
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
