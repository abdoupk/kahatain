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

    $this->family->load(['sponsor']);

    // suppose orphan is baby when weight is always equal to 1
    $this->orphan = Orphan::factory()->create([
        'sponsor_id' => $this->family->sponsor->id,
        'family_id' => $this->family->id,
        'tenant_id' => $this->tenant->id,
        'birth_date' => now()->subDays(80),
        'income' => 0,
    ]);
});

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة) and employed.', function () {
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

it('correctly calculates total income for family when sponsor is widows husband (زوج الأرملة) and unemployed.', function () {
    $this->family->sponsor->update(['is_unemployed' => true]);

    $this->incomes = $this->family->sponsor->incomes()->create([
        'tenant_id' => $this->tenant->id,
        'other_income' => 4000,
        'total_income' => 4000,
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

    monthlySponsorship($this->family);

    expect($this->family->difference_before_monthly_sponsorship > 0)->toBeFalse()
        ->and(calculateWeights($this->family, $this->calculation))->toBe(2.0)
        ->and($this->family->total_income)->toBe(15000.0)
        ->and($this->family->income_rate)->toBe(7500.0)
        ->and($this->family->difference_before_monthly_sponsorship)->toBe(-3000.0)
        ->and($this->family->amount_from_association)->toBe(0.0)
        ->and($this->family->monthly_sponsorship_rate)->toBe(0.0)
        ->and($this->family->difference_after_monthly_sponsorship)->toBe(
            -3000.0);
})->group('incomes');
