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
            'sponsor_type' => SponsorType::WIDOWS_HUSBAND->value,
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
        'academic_level_id' => null,
        'income' => 1000.0,
        'is_handicapped' => false,
        'gender' => 'female',
        'family_status' => null,
    ]);

    $this->family->load(['sponsor.orphans']);
});

it('correctly calculates income contribution for female orphan college student (licence).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('licence')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(270.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan college student (master 1).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::whereLevel('الأولى ماستر')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(390.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan college student (master 2).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::whereLevel('الثانية ماستر')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(480.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan college student (doctorate).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('doctorate')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(2400.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan college student complete his studies.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(3000.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan is professional.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::PROFESSIONAL_GIRL->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(250.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan is professional the status not set (Vocational training center).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('vocational_training')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(250.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan is professional the status not set (Paramedical).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('paramedical')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(250.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan at home with no income.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::AT_HOME_WITH_NO_INCOME->value,
        'is_unemployed' => true,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))
        ->toBe(3000.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan at home with income.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::AT_HOME_WITH_INCOME->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(300.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan single female / employed.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::SINGLE_FEMALE_EMPLOYEE->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(400.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan married .', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(300.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan divorced with family.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::DIVORCED_WITH_FAMILY->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan divorced outside the family.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::DIVORCED_OUTSIDE_FAMILY->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForFemaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(1000.0);
})->group('incomes');
