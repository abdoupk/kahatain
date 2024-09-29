<?php

namespace Database\Factories;

use App\Models\SponsorSponsorship;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

class SponsorSponsorshipFactory extends Factory
{
    protected $model = SponsorSponsorship::class;

    /**
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'medical_sponsorship' => fake()->boolean(),
            'literacy_lessons' => fake()->boolean(),
            'direct_sponsorship' => fake()->boolean(),
            'project_support' => fake()->boolean(),
            'sponsor_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
