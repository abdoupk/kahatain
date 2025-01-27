<?php

use App\Enums\FamilyStatus;
use App\Enums\SponsorType;
use App\Models\AcademicLevel;
use App\Models\Family;
use App\Models\Orphan;
use App\Models\Tenant;
use Carbon\Carbon;
use Database\Seeders\AcademicLevelSeeder;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\seed;
use function Pest\Laravel\travelTo;

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

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan baby during academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subDays(80),
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
});

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan baby outside academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subDays(80),
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan below school age during academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(3),
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan below school age outside academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(3),
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan in primary school during academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('primary_education')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.25);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan in primary school outside academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('primary_education')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan in middle school during academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('middle_education')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.5);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan in middle school outside academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('middle_education')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan in high school during academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('secondary_education')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.75);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan in high school outside academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('secondary_education')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan is dismissed during academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::whereLevel('مفصول')->first()->id,
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan is dismissed outside academic season when family status not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::whereLevel('مفصول')->first()->id,
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan is dismissed outside academic season when family status selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'family_status' => FamilyStatus::PROFESSIONALS->value,
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan works during academic season when family status selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('vocational_training')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan works during academic season when family status not selected.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'academic_level_id' => AcademicLevel::wherePhaseKey('vocational_training')->inRandomOrder()->first()->id,
    ]);

    travelTo(Carbon::create(2025, 3, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and has orphan works outside academic season.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(18),
        'family_status' => FamilyStatus::PROFESSIONALS->value,
    ]);

    travelTo(Carbon::create(2025, 8, 13));

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');
