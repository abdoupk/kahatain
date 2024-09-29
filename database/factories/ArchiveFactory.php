<?php

namespace Database\Factories;

use App\Models\Archive;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ArchiveFactory extends Factory
{
    protected $model = Archive::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'occasion' => $this->faker->word(),
            'tenant_id' => $this->faker->words(),
            'families_count' => $this->faker->randomNumber(),
            'family_ids' => $this->faker->words(),
            'saved_by' => $this->faker->words(),
        ];
    }
}
