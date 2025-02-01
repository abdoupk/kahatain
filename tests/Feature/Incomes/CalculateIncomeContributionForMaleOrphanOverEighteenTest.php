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
        'gender' => 'male',
        'is_unemployed' => false,
        'family_status' => null,
    ]);

    $this->family->load(['sponsor.orphans']);
});

it('correctly calculates income contribution for male orphan college student (licence).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('licence')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(405.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan college student (master 1).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::whereLevel('الأولى ماستر')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(585.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan college student (master 2).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::whereLevel('الثانية ماستر')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(720.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan college student (doctorate).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('doctorate')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(3600.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan college student complete his studies.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(10000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan is professional.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::PROFESSIONAL_BOY->value,
        'is_unemployed' => true,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(6000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan is professional the status not set (Vocational training center).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'is_unemployed' => true,
        'academic_level_id' => AcademicLevel::wherePhaseKey('vocational_training')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(6000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan is professional the status not set (Paramedical).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'is_unemployed' => true,
        'academic_level_id' => AcademicLevel::wherePhaseKey('paramedical')->first()->id,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(6000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan unemployed.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::UNEMPLOYED->value,
        'is_unemployed' => true,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(10000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan works and with the family.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::WORKER_WITH_FAMILY->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(400.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan works and lives outside the family.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::WORKER_OUTSIDE_FAMILY->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(300.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan married with the family + his family and its employed', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED_WITH_FAMILY->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan married with the family + his family and its not employed', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED_WITH_FAMILY->value,
        'is_unemployed' => true,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(15000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan married with the family + his family and unemployed.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED_WITH_FAMILY->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(1000.0);
})->group('incomes');

it('correctly calculates income contribution for male orphan married outside the family.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED_OUTSIDE_FAMILY->value,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateContributionsForMaleOrphan($this->family->sponsor->orphans->first(), $this->calculation))->toBe(100.0);
})->group('incomes');
