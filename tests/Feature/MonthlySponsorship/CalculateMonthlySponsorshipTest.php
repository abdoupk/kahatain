<?php

use App\Enums\FamilyStatus;
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
        ->hasHousing(1, ['tenant_id' => $this->tenant->id, 'name' => 'tenant', 'value' => 0])
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

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة) and employed.', function () {
    monthlySponsorship($this->family);

    expect($this->family->difference_before_monthly_sponsorship > 0)->toBeTrue()
        ->and(calculateWeights($this->family, $this->calculation))->toBe(2.0)
        ->and($this->family->total_income)->toBe(4000.0)
        ->and($this->family->income_rate)->toBe(2000.0)
        ->and($this->family->difference_before_monthly_sponsorship)->toBe(8000.0)
        ->and($this->family->amount_from_association)->toBe(-400.0)
        ->and($this->family->monthly_sponsorship_rate)->toBe(0.45)
        ->and($this->family->difference_after_monthly_sponsorship)->toBe(
            4400.0);
})->group('incomes');

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة) and employed and housing type is tenant.', function () {
    $this->family->housing()->update([
        'name' => 'tenant',
        'value' => 3000,
    ]);

    monthlySponsorship($this->family);

    expect($this->family->difference_before_monthly_sponsorship > 0)->toBeTrue()
        ->and(calculateWeights($this->family, $this->calculation))->toBe(2.0)
        ->and($this->family->total_income)->toBe(4000.0)
        ->and($this->family->income_rate)->toBe(2000.0)
        ->and($this->family->difference_before_monthly_sponsorship)->toBe(8000.0)
        ->and($this->family->amount_from_association)->toBe(-400.0)
        ->and($this->family->monthly_sponsorship_rate)->toBe(0.45)
        ->and($this->family->difference_after_monthly_sponsorship)->toBe(
            4400.0);
})->group('incomes');

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة) and employed and family has second sponsor lives with family.', function () {
    $this->family->secondSponsor()->create([
        'tenant_id' => $this->tenant->id,
        'with_family' => true,
    ]);

    monthlySponsorship($this->family);

    expect($this->family->difference_before_monthly_sponsorship > 0)->toBeTrue()
        ->and(calculateWeights($this->family, $this->calculation))->toBe(2.0)
        ->and($this->family->total_income)->toBe(4000.0)
        ->and($this->family->income_rate)->toBe(2000.0)
        ->and($this->family->difference_before_monthly_sponsorship)->toBe(8000.0)
        ->and($this->family->amount_from_association)->toBe(-400.0)
        ->and($this->family->monthly_sponsorship_rate)->toBe(0.45)
        ->and($this->family->difference_after_monthly_sponsorship)->toBe(
            4400.0);
})->group('incomes');

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة) and employed and family and orphan income = 10000.', function () {
    $this->orphan->update([
        'income' => 10000,
        'is_handicapped' => false,
        'is_unemployed' => false,
        'birth_date' => now()->subYears(20),
        'family_status' => FamilyStatus::COLLEGE_BOY->value,
        'gender' => 'male',
    ]);

    monthlySponsorship($this->family);

    expect($this->family->difference_before_monthly_sponsorship > 0)->toBeTrue()
        ->and(calculateWeights($this->family, $this->calculation))->toBe(2.0)
        ->and($this->family->total_income)->toBe(4000.0)
        ->and($this->family->income_rate)->toBe(2000.0)
        ->and($this->family->difference_before_monthly_sponsorship)->toBe(8000.0)
        ->and($this->family->amount_from_association)->toBe(-400.0)
        ->and($this->family->monthly_sponsorship_rate)->toBe(0.45)
        ->and($this->family->difference_after_monthly_sponsorship)->toBe(
            4400.0);
})->group('incomes');

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة) and employed and the family has benefactor.', function () {
    monthlySponsorship($this->family);

    expect($this->family->difference_before_monthly_sponsorship > 0)->toBeTrue()
        ->and(calculateWeights($this->family, $this->calculation))->toBe(2.0)
        ->and($this->family->total_income)->toBe(4000.0)
        ->and($this->family->income_rate)->toBe(2000.0)
        ->and($this->family->difference_before_monthly_sponsorship)->toBe(8000.0)
        ->and($this->family->amount_from_association)->toBe(-400.0)
        ->and($this->family->monthly_sponsorship_rate)->toBe(0.45)
        ->and($this->family->difference_after_monthly_sponsorship)->toBe(
            4400.0);
})->group('incomes');
