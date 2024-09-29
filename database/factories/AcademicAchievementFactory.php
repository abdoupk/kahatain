<?php

namespace Database\Factories;

use App\Models\AcademicAchievement;
use App\Models\AcademicLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicAchievementFactory extends Factory
{
    protected $model = AcademicAchievement::class;

    public function definition(): array
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'orphan_id' => fake()->uuid,
            'academic_level_id' => AcademicLevel::inRandomOrder()->first()->id,
            'academic_year' => now()->subYears(fake()->numberBetween(0, 3))->year,
            'first_trimester' => fake()->randomFloat(min: 3, max: 18),
            'second_trimester' => fake()->randomFloat(min: 3, max: 18),
            'third_trimester' => fake()->randomFloat(min: 3, max: 18),
            'average' => fake()->randomFloat(min: 3, max: 18),
            'tenant_id' => fake()->uuid,
            'note' => fake('ar_SA')->realText(5000),
        ];
    }
}
