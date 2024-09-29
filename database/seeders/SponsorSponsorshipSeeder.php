<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\SponsorSponsorship;
use Illuminate\Database\Seeder;

class SponsorSponsorshipSeeder extends Seeder
{
    public function run(): void
    {
        Sponsor::get(['id', 'tenant_id'])->each(function (Sponsor $sponsor) {
            SponsorSponsorship::factory()->create([
                'sponsor_id' => $sponsor->id,
                'tenant_id' => $sponsor->tenant_id,
            ]);
        });
    }
}
