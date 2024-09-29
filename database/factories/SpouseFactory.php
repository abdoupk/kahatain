<?php

namespace Database\Factories;

use App\Models\Spouse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpouseFactory extends Factory
{
    protected $model = Spouse::class;

    public function definition(): array
    {
        return [
            'first_name' => fake('ar_SA')->firstName,
            'last_name' => fake('ar_SA')->lastName,
            'birth_date' => now()->subYears(30)->toDate(),
            'death_date' => Carbon::now()->toDate(),
            'function' => fake('ar_SA')->jobTitle,
            'income' => fake()->randomFloat(),
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
