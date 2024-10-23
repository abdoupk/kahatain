<?php

namespace Database\Seeders;

use App\Models\Sponsorship;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class SponsorShipSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::select('id')->lazy(100)->each(function (Tenant $tenant) {
            Sponsorship::factory()->count(fake()->numberBetween(1, 5))->create([
                'tenant_id' => $tenant->id,
                'created_by' => $tenant->members->random()->id,
            ]);
        });
    }
}
