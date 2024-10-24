<?php

namespace Database\Factories;

use App\Models\Sponsorship;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorshipFactory extends Factory
{
    protected $model = Sponsorship::class;

    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(1000, 5000),
            'created_by' => fake()->uuid,
            'benefactor_id' => fake()->uuid,
            'sponsorship_type' => fake()->randomElement(['monthly_basket', 'cash', 'ccp']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
