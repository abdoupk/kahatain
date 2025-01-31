<?php

use App\Models\Family;
use App\Models\Orphan;
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

    $this->orphan = Orphan::factory()->create([
        'birth_date' => now()->subYears(18),
        'family_id' => $this->family->id,
        'tenant_id' => $this->tenant->id,
        'gender' => 'male',
        'sponsor_id' => $this->family->sponsor->id,
    ]);
})->group('incomes');

it('correctly calculates income contribution for male orphan under 18', function () {
    expect(calculateOrphanIncomes($this->orphan))->toBe(0.0);
})->group('incomes');

it('correctly calculates income contribution for female orphan under 18', function () {
    $this->orphan->update(['gender' => 'female']);

    expect(calculateOrphanIncomes($this->orphan))->toBe(0.0);
})->group('incomes');

it('correctly calculates income contribution for handicapped orphan under 18', function () {
    $this->orphan->update(['is_handicapped' => true]);

    expect(calculateOrphanIncomes($this->orphan))->toBe(10000.0);
})->group('incomes');
