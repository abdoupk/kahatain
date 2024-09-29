<?php

namespace Database\Factories;

use App\Models\ClothesSize;
use App\Models\Orphan;
use App\Models\ShoeSize;
use App\Models\User;
use App\Models\VocationalTraining;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrphanFactory extends Factory
{
    protected $model = Orphan::class;

    private array $family_statuses = [
        'college_girl',
        'professional_girl',
        'at_home_with_no_income',
        'at_home_with_income',
        'single_female_employee',
        'married',
        'divorced',
        'college_boy',
        'professional_boy',
        'unemployed',
        'worker_with_family',
        'worker_outside_family',
        'married_with_family',
        'married_outside_family',
    ];

    public function definition(): array
    {
        return [
            'first_name' => fake('ar_SA')->firstName,
            'last_name' => fake('ar_SA')->lastName,
            'birth_date' => now()->subYears(fake()->numberBetween(0, 4))->subDays(fake()->numberBetween(1, 365))->subMonths(fake()->numberBetween(1, 12))->toDate(),
            'family_status' => fake('ar_SA')->randomElement($this->family_statuses),
            'health_status' => fake('ar_SA')->realText('10'),
            //            'academic_level_id' => AcademicLevel::inRandomOrder()->first()->id,
            'academic_level_id' => 5,
            'vocational_training_id' => VocationalTraining::inRandomOrder()->first()->id,
            'shoes_size' => ShoeSize::inRandomOrder()->first()->id,
            'pants_size' => ClothesSize::inRandomOrder()->first()->id,
            'shirt_size' => ClothesSize::inRandomOrder()->first()->id,
            'gender' => fake()->randomElement(['male', 'female']),
            'income' => fake()->numberBetween(0, 100000),
            'note' => fake('ar_SA')->realText(500),
            'is_handicapped' => fake()->boolean(20),
            'is_unemployed' => fake()->boolean(60),
            'tenant_id' => fake()->uuid,
            'family_id' => fake()->uuid,
            'created_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'updated_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'created_by' => User::inRandomOrder()->first()?->id,
            'deleted_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
