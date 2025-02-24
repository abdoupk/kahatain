<?php

use App\Models\Family;
use App\Models\Tenant;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed(CitySeeder::class);

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

    $this->family = Family::factory()
        ->hasSponsor(1, ['tenant_id' => $this->tenant->id, 'is_unemployed' => false])
        ->hasZone(1, ['tenant_id' => $this->tenant->id])
        ->hasBranch(1, ['tenant_id' => $this->tenant->id])
        ->create(['tenant_id' => $this->tenant->id]);

    $this->family->load(['sponsor']);
});

it('correctly calculates total income for sponsor when other income is not null and account is null when is employed', function () {
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

    expect(setTotalIncomeAttribute($this->incomes->toArray(), $this->family->sponsor))->toBe(4000.0);
})->group('incomes');

it('correctly calculates total income for sponsor when other income is null and account is not null when is unemployed', function () {
    $this->incomes = $this->family->sponsor->incomes()->create([
        'tenant_id' => $this->tenant->id,
        'other_income' => null,
        'account' => [
            'ccp' => [
                'monthly_income' => 1200,
                'balance' => 400,
                'performance_grant' => 1200,
            ],
            'bank' => [
                'monthly_income' => 1200,
                'balance' => 400,
                'performance_grant' => 1200,
            ],
        ],
    ]);

    expect(setTotalIncomeAttribute($this->incomes->toArray(), $this->family->sponsor))->toBe(4000.0);
})->group('incomes');

it('correctly calculates total income for sponsor when other income is not null and account is not null when is unemployed', function () {
    $this->incomes = $this->family->sponsor->incomes()->create([
        'tenant_id' => $this->tenant->id,
        'other_income' => 4000,
        'account' => [
            'ccp' => [
                'monthly_income' => 1200,
                'balance' => 400,
                'performance_grant' => 1200,
            ],
            'bank' => [
                'monthly_income' => 1200,
                'balance' => 400,
                'performance_grant' => 1200,
            ],
        ],
    ]);

    expect(setTotalIncomeAttribute($this->incomes->toArray(), $this->family->sponsor))->toBe(8000.0);
})->group('incomes');
