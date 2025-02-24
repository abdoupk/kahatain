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
    ]);
});

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and college student not complete his studies and family status not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->inRandomOrder()->first()->id,
        'gender' => 'male',
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and college student and complete his studies and family status not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->whereLevel('متخرج')->first()->id,
        'gender' => 'male',
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and in university and academic level not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::COLLEGE_BOY->value,
        'gender' => 'male',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and in vocational training center.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::PROFESSIONAL_BOY->value,
        'gender' => 'male',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and unemployed.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::UNEMPLOYED->value,
        'gender' => 'male',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and works and with the family.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::WORKER_WITH_FAMILY->value,
        'gender' => 'male',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and works and lives outside the family.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::WORKER_OUTSIDE_FAMILY->value,
        'gender' => 'male',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and married with the family + his family.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED_WITH_FAMILY->value,
        'gender' => 'male',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is male and married outside the family.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED_OUTSIDE_FAMILY->value,
        'gender' => 'male',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.0);
})->group('weights');
