<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Housing;
use Illuminate\Database\Seeder;

class HousingSeeder extends Seeder
{
    public function run(): void
    {
        Family::select(['id', 'tenant_id'])->lazy(100)->each(function (Family $family) {
            Housing::factory()->create([
                'family_id' => $family->id,
                'tenant_id' => $family->tenant_id,
            ]);
        });
    }
}
