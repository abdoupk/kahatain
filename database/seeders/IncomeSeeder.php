<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\Sponsor;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    public function run(): void
    {
        Sponsor::select(['id', 'tenant_id'])->lazy(100)->each(static function (Sponsor $sponsor) {
            Income::factory()->create([
                'sponsor_id' => $sponsor->id,
                'tenant_id' => $sponsor->tenant_id,
            ]);
        });
    }
}
