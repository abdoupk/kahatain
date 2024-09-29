<?php

namespace Database\Seeders;

use App\Models\PrivateSchool;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class PrivateSchoolSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::select('id')->lazy(100)->each(function (Tenant $tenant) {
            PrivateSchool::factory()->count(10)->create([
                'tenant_id' => $tenant->id,
            ]);
        });
    }
}
