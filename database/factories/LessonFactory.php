<?php

namespace Database\Factories;

use App\Models\AcademicLevel;
use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'subject_id' => Subject::inRandomOrder()->first()->id,
            'academic_level_id' => AcademicLevel::inRandomOrder()->first()->id,
            'quota' => fake()->numberBetween(1, 10),
            'tenant_id' => fake()->uuid,
        ];
    }
}
