<?php

use App\Enums\SponsorType;
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
        ])->hasSecondSponsor(1, [
            'tenant_id' => $this->tenant->id,
            'with_family' => false,
            'income' => 1000,
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
        'family_status' => null,
    ]);

    $this->family->load(['sponsor.orphans']);
});

it('calculate income contribution for family has second sponsor with family.', function () {
    $this->family->secondSponsor()->update(['with_family' => true]);

    $this->family->load(['secondSponsor']);

    expect(calculateContributionsForSecondSponsor($this->family))->toBe(1000.0);
})->group('incomes');

it('calculate income contribution for family has second sponsor without family.', function () {
    $this->family->load(['secondSponsor']);

    expect(calculateContributionsForSecondSponsor($this->family))->toBe(1000.0);
})->group('incomes');

it('calculate income contribution for family handicapped orphan.', function () {
    $this->orphan->update(['is_handicapped' => true]);

    $this->family->load(['sponsor.orphans']);

    expect(calculateOrphanIncomes($this->family->sponsor->orphans->first()))->toBe(10000.0);
})->group('incomes');
