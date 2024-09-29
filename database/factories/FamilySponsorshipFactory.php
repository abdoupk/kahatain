<?php

namespace Database\Factories;

use App\Models\FamilySponsorship;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilySponsorshipFactory extends Factory
{
    protected $model = FamilySponsorship::class;

    public function definition(): array
    {
        return [
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
            'monthly_allowance' => fake()->numberBetween(1000, 100000),
            'ramadan_basket' => fake()->boolean,
            'zakat' => fake()->boolean,
            'housing_assistance' => fake()->boolean,
            'eid_al_adha' => fake()->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
