<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Furnishing;
use Illuminate\Database\Seeder;

class FurnishingSeeder extends Seeder
{
    public function run(): void
    {
        Family::select(['id', 'tenant_id'])->lazy(100)->each(function (Family $family) {
            Furnishing::factory()->create([
                'family_id' => $family->id,
                'tenant_id' => $family->tenant_id,
            ]);
        });
    }
}
