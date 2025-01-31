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
        ->hasSponsor(1, ['tenant_id' => $this->tenant->id, 'sponsor_type' => SponsorType::WIDOWS_HUSBAND, 'is_unemployed' => false])
        ->hasZone(1, ['tenant_id' => $this->tenant->id])
        ->hasBranch(1, ['tenant_id' => $this->tenant->id])
        ->create(['tenant_id' => $this->tenant->id]);

    $this->family->load(['sponsor.orphans']);

    // suppose orphan is baby when weight is always equal to 1
    $this->orphan = Orphan::factory()->create([
        'sponsor_id' => $this->family->sponsor->id,
        'family_id' => $this->family->id,
        'tenant_id' => $this->tenant->id,
        'birth_date' => now()->subDays(80),
        'is_handicapped' => false,
        'income' => 0,
    ]);

    $this->incomes = $this->family->sponsor->incomes()->create([
        'tenant_id' => $this->tenant->id,
        'other_income' => 4000,
        'account' => [
            'ccp' => [
                'monthly_income' => null,
                'balance' => null,
                'performance_grant' => null,
            ],
            'bank' => [
                'monthly_income' => null,
                'balance' => null,
                'performance_grant' => null,
            ],
        ],
    ]);

    $this->incomes->update([
        'total_income' => setTotalIncomeAttribute($this->incomes->toArray(), $this->family->sponsor),
    ]);
});

it('correctly get ramadan sponsorship differance and category for category one.', function () {
    monthlySponsorship($this->family);

    expect($this->family->ramadan_sponsorship_difference)->toBe(
        4400.0)
        ->and($this->family->ramadan_basket_category)->toBe(
            4400.0);
});

it('correctly get ramadan sponsorship differance and category for category two.', function () {
    monthlySponsorship($this->family);

    expect($this->family->ramadan_sponsorship_difference)->toBe(
        4400.0)
        ->and($this->family->ramadan_basket_category)->toBe(
            4400.0);
});

it('correctly get ramadan sponsorship differance and category for category three.', function () {
    monthlySponsorship($this->family);

    expect($this->family->ramadan_sponsorship_difference)->toBe(
        4400.0)
        ->and($this->family->ramadan_basket_category)->toBe(
            4400.0);
});

it('correctly get ramadan sponsorship differance and category for family does not benefit.', function () {
    monthlySponsorship($this->family);

    expect($this->family->ramadan_sponsorship_difference)->toBe(
        4400.0)
        ->and($this->family->ramadan_basket_category)->toBe(
            4400.0);
});
