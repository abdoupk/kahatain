<?php

namespace Database\Factories;

use App\Models\PrivateSchool;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivateSchoolFactory extends Factory
{
    protected $model = PrivateSchool::class;

    public function definition(): array
    {
        return [
            'name' => fake('ar_SA')->word,
            'tenant_id' => fake()->uuid,
            'created_by' => User::inRandomOrder()->first()->id,
            'deleted_by' => User::inRandomOrder()->first()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
