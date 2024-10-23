<?php

namespace Database\Seeders;

use App\Models\Benefactor;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class BenefactorSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::select('id')->lazy(100)->each(function (Tenant $tenant) {
            Benefactor::factory()->count(fake()->numberBetween(10, 25))->create([
                'tenant_id' => $tenant->id,
                'created_by' => $tenant->members->random()->id,
            ]);
        });
    }
}
