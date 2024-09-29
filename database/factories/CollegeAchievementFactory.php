<?php

namespace Database\Factories;

use App\Models\AcademicLevel;
use App\Models\CollegeAchievement;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollegeAchievementFactory extends Factory
{
    protected $model = CollegeAchievement::class;

    public function definition(): array
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'orphan_id' => fake()->uuid,
            'first_semester' => fake()->randomFloat(min: 3, max: 18),
            'second_semester' => fake()->randomFloat(min: 3, max: 18),
            'speciality' => fake()->word(),
            'academic_level_id' => AcademicLevel::inRandomOrder()->first()->id,
            'average' => fake()->randomFloat(min: 3, max: 18),
            'year' => fake()->numberBetween(2010, 2020),
            'note' => fake('ar_SA')->realText(),
            'university' => fake()->word(),
            'tenant_id' => fake()->uuid,
        ];
    }
}
