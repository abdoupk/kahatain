<?php

namespace Database\Factories;

use App\Models\Lesson;
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
            'subject_id' => $this->faker->randomNumber(),
            'academic_level_id' => $this->faker->randomNumber(),
            'quota' => $this->faker->randomNumber(),
            'tenant_id' => $this->faker->words(),
        ];
    }
}
