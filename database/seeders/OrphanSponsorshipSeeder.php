<?php

namespace Database\Seeders;

use App\Models\Orphan;
use App\Models\OrphanSponsorship;
use Illuminate\Database\Seeder;

class OrphanSponsorshipSeeder extends Seeder
{
    public function run(): void
    {
        Orphan::get(['id', 'tenant_id'])->each((function (Orphan $orphan) {
            OrphanSponsorship::factory()->create([
                'orphan_id' => $orphan->id,
                'tenant_id' => $orphan->tenant_id,
            ]);
        }));
    }
}
