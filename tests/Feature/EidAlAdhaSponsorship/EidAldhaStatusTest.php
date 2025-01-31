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

it('correctly set eid al adha status when the family benefit.', function () {});

it('correctly set eid al adha status when the family dont benefit.', function () {});

it('correctly set eid al adha status when the family benefit (meat)', function () {});
