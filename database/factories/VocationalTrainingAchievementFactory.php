<?php

namespace Database\Factories;

use App\Models\VocationalTrainingAchievement;
use Illuminate\Database\Eloquent\Factories\Factory;

class VocationalTrainingAchievementFactory extends Factory
{
    protected $model = VocationalTrainingAchievement::class;

    public function definition(): array
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'tenant_id' => fake()->uuid,
            'orphan_id' => fake()->uuid,
            'note' => fake('ar_SA')->realText(500),
            'year' => now()->year,
            'institute' => fake('ar_SA')->name,
            'vocational_training_id' => 1,
        ];
    }
}
