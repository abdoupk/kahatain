<?php

use App\Enums\SponsorType;
use App\Models\AcademicLevel;
use App\Models\City;
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
            'domain' => 'foo.'.config('app.domain'),
            'association' => 'kafil el yatim El-bayadh ',
            'city_id' => 1144,
            'city' => [
                'id' => 1144,
                'daira_name' => 'البيض',
                'wilaya_code' => '32',
                'wilaya_name' => 'البيض',
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
        ->hasBranch(1, ['tenant_id' => $this->tenant->id, 'city_id' => City::inRandomOrder()->first()->id])
        ->create([
            'tenant_id' => $this->tenant->id,
            'created_by' => \App\Models\User::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        ]);

    $this->family->load(['sponsor']);

    $this->orphan = Orphan::factory()->create([
        'sponsor_id' => $this->family->sponsor->id,
        'family_id' => $this->family->id,
        'created_by' => \App\Models\User::inRandomOrder()->whereTenantId($this->tenant->id)->first()->id,
        'tenant_id' => $this->tenant->id,
        'birth_date' => now()->subDays(80),
    ]);
});

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and the orphan is handicapped.', function () {
    $this->orphan->update([
        'birth_date' => now()->subYears(20),
        'is_handicapped' => true,
    ]);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.0);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and the family has second sponsor lives with the family.', function () {
    $this->orphan->update([
        'academic_level_id' => AcademicLevel::wherePhaseKey('middle_education')->inRandomOrder()->first()->id,
        'birth_date' => now()->subYears(16),
    ]);

    travelTo(Carbon::create(2025, 1, 13));

    $this->family->secondSponsor()->create([
        'family_id' => $this->family->id,
        'tenant_id' => $this->family->tenant_id,
        'with_family' => true,
    ]);

    $this->family->load(['secondSponsor']);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(3.5);
})->group('weights');

it('correctly calculates weights for family when sponsor is widow`s husband (زوج الأرملة) and the family has second sponsor outside the family.', function () {
    $this->orphan->update([
        'academic_level_id' => AcademicLevel::wherePhaseKey('primary_education')->inRandomOrder()->first()->id,
        'birth_date' => now()->subYears(16),
    ]);

    travelTo(Carbon::create(2025, 1, 13));

    $this->family->secondSponsor()->create([
        'family_id' => $this->family->id,
        'tenant_id' => $this->family->tenant_id,
        'with_family' => false,
    ]);

    $this->family->load(['secondSponsor']);

    expect(calculateWeights($this->family, $this->calculation))
        ->toBe(2.25);
})->group('weights');
