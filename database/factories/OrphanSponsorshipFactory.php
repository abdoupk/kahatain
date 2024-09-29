<?php

namespace Database\Factories;

use App\Models\OrphanSponsorship;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrphanSponsorshipFactory extends Factory
{
    protected $model = OrphanSponsorship::class;

    public function definition(): array
    {
        return [
            'orphan_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
            'medical_sponsorship' => fake()->boolean,
            'university_scholarship' => fake()->boolean,
            'association_trips' => fake()->boolean,
            'summer_camp' => fake()->boolean,
            'eid_suit' => fake()->boolean,
            'private_lessons' => fake()->boolean,
            'school_bag' => fake()->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
