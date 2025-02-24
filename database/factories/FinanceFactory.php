<?php

namespace Database\Factories;

use App\Enums\DonationSpecification;
use App\Models\Finance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinanceFactory extends Factory
{
    protected $model = Finance::class;

    public function definition(): array
    {
        return [
            'amount' => fake()->numberBetween(-1000000, 1000000),
            'description' => fake('ar_SA')->realText(),
            'date' => now()->subDays(fake()->numberBetween(1, 913)),
            'specification' => fake()->randomElement(array_map(fn ($type) => $type->value, DonationSpecification::cases())),
            'received_by' => User::inRandomOrder()->first()->id,
            'created_by' => User::inRandomOrder()->first()->id,
            'tenant_id' => fake()->uuid,
            'created_at' => now()->subDays(fake()->numberBetween(1, 913)),
            'updated_at' => now(),
            'deleted_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
