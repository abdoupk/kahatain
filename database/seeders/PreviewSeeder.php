<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\MemberPreview;
use App\Models\Preview;
use App\Models\User;
use Illuminate\Database\Seeder;

class PreviewSeeder extends Seeder
{
    public function run(): void
    {
        Family::lazy(100)->each(function (Family $family) {
            $preview = Preview::factory()->create(
                [
                    'family_id' => $family->id,
                    'tenant_id' => $family->tenant_id,
                ]
            );

            for ($i = 0; $i < fake()->numberBetween(1, 5); $i++) {
                MemberPreview::factory()->create([
                    'preview_id' => $preview->id,
                    'tenant_id' => $family->tenant_id,
                    'user_id' => User::inRandomOrder()->whereTenantId($family->tenant_id)->first()?->id,
                ]);
            }
        });
    }
}
