<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\FamilySponsorship;
use Illuminate\Database\Seeder;

class FamilySponsorshipSeeder extends Seeder
{
    public function run(): void
    {
        Family::lazy(100)->each(function (Family $family) {
            FamilySponsorship::factory()->create([
                'family_id' => $family->id,
                'tenant_id' => $family->tenant_id,
            ]);
        });
    }
}
