<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
            'title' => fake('ar_SA')->word,
            'description' => fake('ar_SA')->text,
            'school_id' => fake('ar_SA')->words,
            'start_date' => now(),
            'end_date' => now(),
            'tenant_id' => fake()->uuid,
            'created_by' => User::inRandomOrder()->first()->id,
            'deleted_by' => User::inRandomOrder()->first()->id,
            'color' => fake('ar_SA')->word,
        ];
    }
}
