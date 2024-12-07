<?php

namespace Database\Factories;

use App\Models\AcademicLevel;
use App\Models\ClothesSize;
use App\Models\Orphan;
use App\Models\School;
use App\Models\ShoeSize;
use App\Models\University;
use App\Models\User;
use App\Models\VocationalTraining;
use App\Models\VocationalTrainingCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrphanFactory extends Factory
{
    protected $model = Orphan::class;

    private array $familyStatuses = [
        'female' => [
            'college_girl',
            'professional_girl',
            'at_home_with_no_income',
            'at_home_with_income',
            'single_female_employee',
            'married',
            'divorced_with_family',
            'divorced_outside_family',
        ],
        'male' => [
            'college_boy',
            'professional_boy',
            'unemployed',
            'worker_with_family',
            'worker_outside_family',
            'married_with_family',
            'married_outside_family',
        ],
    ];

    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);

        $handicapped = fake()->boolean(20);

        $birth_date = now()->subYears(fake()->numberBetween(0, 20))->subDays(fake()->numberBetween(1, 365))->subMonths(fake()->numberBetween(1, 12));

        $unemployed = false;

        $family_status = null;

        if ($birth_date->age > 18 && ! $handicapped) {
            $family_status = $gender === 'male' ? fake()->randomElement($this->familyStatuses['male']) : fake()->randomElement($this->familyStatuses['female']);
        }

        if ($family_status === 'unemployed') {
            $unemployed = true;
        }
        $institution_id = null;

        $institution_type = fake()->randomElement(['school', 'university', 'vocational_training_center']);

        if ($institution_type === 'vocational_training_center') {
            $institution_id = VocationalTrainingCenter::inRandomOrder()->first()->id;
        }

        if ($institution_type === 'school') {
            $institution_id = School::inRandomOrder()->first()->id;
        }

        if ($institution_type === 'university') {
            $institution_id = University::inRandomOrder()->first()->id;
        }

        return [
            'first_name' => fake('ar_SA')->firstName,
            'last_name' => fake('ar_SA')->lastName,
            'birth_date' => $birth_date->toDate(),
            'family_status' => $family_status,
            'health_status' => fake('ar_SA')->realText('10'),
            'academic_level_id' => AcademicLevel::inRandomOrder()->first()->id,
            'vocational_training_id' => VocationalTraining::inRandomOrder()->first()->id,
            'shoes_size' => ShoeSize::inRandomOrder()->first()->id,
            'pants_size' => ClothesSize::inRandomOrder()->first()->id,
            'shirt_size' => ClothesSize::inRandomOrder()->first()->id,
            'gender' => $gender,
            'income' => fake()->numberBetween(0, 10000),
            'note' => fake('ar_SA')->realText(500),
            'is_handicapped' => $handicapped,
            'is_unemployed' => $unemployed,
            'tenant_id' => fake()->uuid,
            'family_id' => fake()->uuid,
            'institution_id' => $institution_id,
            'institution_type' => $institution_type,
            'created_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'updated_at' => now()->subDays(fake()->numberBetween(0, 35)),
            'created_by' => User::inRandomOrder()->first()?->id,
            'deleted_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
