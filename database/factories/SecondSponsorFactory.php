<?php

namespace Database\Factories;

use App\Models\SecondSponsor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecondSponsorFactory extends Factory
{
    protected $model = SecondSponsor::class;

    public function definition(): array
    {
        return [
            'first_name' => fake('ar_SA')->firstName,
            'last_name' => fake('ar_SA')->lastName,
            'degree_of_kinship' => fake('ar_SA')->word,
            'phone_number' => fake('ar_SA')->regexify('(06|07|05)[0-9]{8}'),
            'address' => fake('ar_SA')->address,
            'income' => fake('ar_SA')->numberBetween(1000, 5000),
            'family_id' => fake()->uuid,
            'tenant_id' => fake()->uuid,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
