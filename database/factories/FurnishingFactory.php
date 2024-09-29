<?php

namespace Database\Factories;

use App\Models\Furnishing;
use Illuminate\Database\Eloquent\Factories\Factory;

class FurnishingFactory extends Factory
{
    protected $model = Furnishing::class;

    public function definition(): array
    {
        return [
            'television' => fake('ar_SA')->word,
            'refrigerator' => fake('ar_SA')->word,
            'fireplace' => fake('ar_SA')->word,
            'washing_machine' => fake('ar_SA')->word,
            'water_heater' => fake('ar_SA')->word,
            'oven' => fake('ar_SA')->word,
            'wardrobe' => fake('ar_SA')->word,
            'cupboard' => fake('ar_SA')->word,
            'covers' => fake('ar_SA')->word,
            'mattresses' => fake('ar_SA')->word,
            'other_furnishings' => fake('ar_SA')->word,
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
        ];
    }
}
