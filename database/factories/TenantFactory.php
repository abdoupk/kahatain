<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'infos' => [
                'super_admin' => [
                    'id' => fake()->uuid,
                    'first_name' => fake('ar_SA')->firstName,
                    'last_name' => fake('ar_SA')->lastName,
                    'name' => fake('ar_SA')->name,
                    'email' => fake()->safeEmail,
                    'password' => 'password',
                ],
                'domain' => Str::domain(fake()->word.'-'.fake()->word),
                'association' => fake('ar_SA')->company,
            ],
        ];
    }
}
