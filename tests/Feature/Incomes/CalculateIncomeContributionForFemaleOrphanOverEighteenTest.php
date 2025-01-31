<?php

use App\Enums\FamilyStatus;
use App\Enums\SponsorType;
use App\Models\AcademicLevel;
use App\Models\Family;
use App\Models\Orphan;
use App\Models\Tenant;
use Database\Seeders\AcademicLevelSeeder;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed(CitySeeder::class);

    seed(AcademicLevelSeeder::class);

    $this->tenant = Tenant::factory()->create([
        'infos' => [
            'super_admin' => [
                'first_name' => 'Rezig',
                'last_name' => 'Chikh',
                'password' => 'password',
                'email' => 'test@example.com',
            ],
        ],
    ]);

    $this->calculation = json_decode($this->tenant->calculation, true);

    $this->family = Family::factory()
        ->hasSponsor(1, [
            'sponsor_type' => SponsorType::WIDOWS_HUSBAND,
            'tenant_id' => $this->tenant->id,
        ])
        ->hasZone(1, ['tenant_id' => $this->tenant->id])
        ->hasBranch(1, ['tenant_id' => $this->tenant->id])
        ->create(['tenant_id' => $this->tenant->id]);

    $this->family->load(['sponsor']);

    $this->orphan = Orphan::factory()->create([
        'sponsor_id' => $this->family->sponsor->id,
        'family_id' => $this->family->id,
        'tenant_id' => $this->tenant->id,
        'birth_date' => now()->subDays(80),
        'income' => 1000,
    ]);
});

it('correctly calculates income contribution for female orphan and college student not complete his studies and family status not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->inRandomOrder()->first()->id,
        'gender' => 'female',
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(3000.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and college student and complete his studies and family status not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->whereLevel('متخرج')->first()->id,
        'gender' => 'female',
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(3000.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and in university and academic level not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::COLLEGE_GIRL->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(200.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and works.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::PROFESSIONAL_GIRL->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(250.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and in house and without income.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::AT_HOME_WITH_NO_INCOME->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(3000.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and in house with grant (منحة البطالة).', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::AT_HOME_WITH_INCOME->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(300.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and single.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::SINGLE_FEMALE_EMPLOYEE->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(400.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and married.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(300.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and divorced with family.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::DIVORCED_WITH_FAMILY->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan and divorced without family.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::DIVORCED_OUTSIDE_FAMILY->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(1000.0);
})->group('incomes');
