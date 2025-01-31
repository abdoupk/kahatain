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

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and college student not complete his studies and family status not selected.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->inRandomOrder()->first()->id,
        'gender' => 'female',
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and college student and complete his studies and family status not selected.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'academic_level_id' => AcademicLevel::wherePhaseKey('university')->whereLevel('متخرج')->first()->id,
        'gender' => 'female',
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and in university and academic level not selected.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::COLLEGE_GIRL->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and works.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::PROFESSIONAL_GIRL->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and in house and without income.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::AT_HOME_WITH_NO_INCOME->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and in house with grant (منحة البطالة).', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::AT_HOME_WITH_INCOME->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and single.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::SINGLE_FEMALE_EMPLOYEE->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and married.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::MARRIED->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and divorced with family.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::DIVORCED_WITH_FAMILY->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and orphan is female and divorced without family.', function () {
    $this->family->sponsor->orphans()->first()->update([
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::DIVORCED_OUTSIDE_FAMILY->value,
        'gender' => 'female',
        'academic_level_id' => null,
        'is_handicapped' => false,
    ]);

    $this->family->load('sponsor.orphans');

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(1.0);
})->group('weights');
