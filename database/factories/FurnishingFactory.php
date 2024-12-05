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
            'television' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'refrigerator' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'fireplace' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'washing_machine' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'water_heater' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'oven' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'wardrobe' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'cupboard' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'covers' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'mattresses' => [
                'checked' => fake()->boolean(60),
                'note' => fake('ar_SA')->word,
            ],
            'other_furnishings' => fake()->word,
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
        ];
    }
}
