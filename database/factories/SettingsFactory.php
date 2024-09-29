<?php

namespace Database\Factories;

use App\Enums\Appearance;
use App\Enums\ColorScheme;
use App\Enums\Layout;
use App\Enums\Theme;
use App\Models\Settings;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingsFactory extends Factory
{
    protected $model = Settings::class;

    public function definition(): array
    {
        return [
            'theme' => Theme::cases()[fake()->numberBetween(0, count(Theme::cases()) - 1)]->value,
            'color_scheme' => ColorScheme::cases()[fake()->numberBetween(0, count(ColorScheme::cases()) - 1)]->value,
            'layout' => Layout::cases()[fake()->numberBetween(0, count(Layout::cases()) - 1)]->value,
            'appearance' => Appearance::cases()[fake()->numberBetween(0, count(Appearance::cases()) - 1)]->value,
            'notifications' => [
                'branch' => [
                    'created' => fake()->boolean(),
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'zone' => [
                    'created' => fake()->boolean(),
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'orphan' => [
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'sponsor' => [
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'family' => [
                    'created' => fake()->boolean(),
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'school' => [
                    'created' => fake()->boolean(),
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'lesson' => [
                    'created' => fake()->boolean(),
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'member' => [
                    'created' => fake()->boolean(),
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
                'need' => [
                    'created' => fake()->boolean(),
                    'deleted' => fake()->boolean(),
                    'updated' => fake()->boolean(),
                ],
            ],
        ];
    }
}
