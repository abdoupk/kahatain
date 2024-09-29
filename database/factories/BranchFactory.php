<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        return [
            'created_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'updated_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'city_id' => City::inRandomOrder()->first()?->id,
            'president_id' => User::inRandomOrder()->first()?->id,
            'tenant_id' => fake()->uuid,
            'name' => fake('ar_SA')->sentence(5),
            'created_by' => User::inRandomOrder()->first()->id,
            'deleted_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
