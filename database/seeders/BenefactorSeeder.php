<?php

namespace Database\Seeders;

use App\Models\Benefactor;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class BenefactorSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::with('members')->lazy(100)->each(function (Tenant $tenant) {
            $benefactors = Benefactor::factory()->count(fake()->numberBetween(10, 25))->create([
                'tenant_id' => $tenant->id,
                'created_by' => $tenant->members->random()->id,
            ]);

            $benefactors->searchable();
        });
    }
}
