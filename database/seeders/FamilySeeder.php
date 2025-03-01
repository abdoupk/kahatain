<?php

namespace Database\Seeders;

use App\Models\AcademicLevel;
use App\Models\Baby;
use App\Models\Branch;
use App\Models\Family;
use App\Models\Inventory;
use App\Models\Need;
use App\Models\Orphan;
use App\Models\SecondSponsor;
use App\Models\Sponsor;
use App\Models\Spouse;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Seeder;
use JsonException;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        Tenant::with('members')->get()->each(
            /**
             * @throws JsonException
             */
            function (Tenant $tenant) {
                for ($i = 0; $i < 10; $i++) {
                    $sponsor_first_name = fake('ar_SA')->firstName();
                    $sponsor_last_name = fake('ar_SA')->lastName();
                    $family = Family::factory()
                        ->hasHousing(1, [
                            'tenant_id' => $tenant->id,
                        ])
                        ->hasFurnishings(1, [
                            'tenant_id' => $tenant->id,
                        ])
                        ->hasAid(fake()->numberBetween(0, 3), function (array $attributes, Family $family) use ($tenant) {
                            return [
                                'tenant_id' => $family->tenant_id,
                                'benefactor_id' => $family->tenant->benefactors->random()->id,
                                'recipientable_id' => $family->id,
                                'created_by' => $tenant->members->random()->id,
                                'recipientable_type' => 'family',
                            ];
                        })
                        ->create([
                            'tenant_id' => $tenant->id,
                            'branch_id' => Branch::whereTenantId($tenant->id)->inRandomOrder()->first()?->id,
                            'zone_id' => Zone::whereTenantId($tenant->id)->inRandomOrder()->first()?->id,
                            'created_by' => User::whereTenantId($tenant->id)->inRandomOrder()->first()->id,
                            'name' => $sponsor_first_name.' '.$sponsor_last_name,
                        ]);

                    Spouse::factory()->create([
                        'tenant_id' => $tenant->id,
                        'family_id' => $family->id,
                    ]);

                    SecondSponsor::factory()->create([
                        'tenant_id' => $tenant->id,
                        'family_id' => $family->id,
                    ]);

                    $sponsor = Sponsor::factory()
                        ->hasIncomes(1, function (array $attributes, Sponsor $sponsor) {
                            return [
                                'tenant_id' => $sponsor->tenant_id,
                            ];
                        })
                        ->create([
                            'tenant_id' => $tenant->id,
                            'family_id' => $family->id,
                            'created_by' => User::whereTenantId($tenant->id)->inRandomOrder()->first()?->id,
                            'first_name' => $sponsor_first_name,
                            'last_name' => $sponsor_last_name,
                        ]);

                    for ($j = 0; $j < fake()->numberBetween(2, 6); $j++) {

                        if ($i == 0) {
                            $orphan = Orphan::factory()
                                ->hasAid(fake()->numberBetween(0, 3), function (array $attributes, Orphan $orphan) use ($tenant) {
                                    return [
                                        'tenant_id' => $orphan->tenant_id,
                                        'benefactor_id' => $orphan->tenant->benefactors->random()->id,
                                        'created_by' => $tenant->members->random()->id,
                                        'sponsorship_type' => fake()->randomElement(['social_sponsorship', 'educational_sponsorship']),
                                        'recipientable_id' => $orphan->id,
                                        'recipientable_type' => 'orphan',
                                    ];
                                })->create([
                                    'tenant_id' => $tenant->id,
                                    'family_id' => $family?->id,
                                    'created_by' => User::whereTenantId($tenant->id)->first()?->id,
                                    'sponsor_id' => $sponsor->id,
                                ]);
                        } else {
                            $orphan = Orphan::factory()->create([
                                'tenant_id' => $tenant->id,
                                'family_id' => $family?->id,
                                'created_by' => User::whereTenantId($tenant->id)->first()?->id,
                                'academic_level_id' => AcademicLevel::inRandomOrder()->first()?->id,
                                'sponsor_id' => $sponsor->id,
                            ]);
                        }

                        Baby::factory()->create([
                            'tenant_id' => $tenant->id,
                            'orphan_id' => $orphan->id,
                            'family_id' => $family->id,
                            'diapers_type' => Inventory::whereTenantId($tenant->id)->inRandomOrder()->first()?->id,
                            'baby_milk_type' => Inventory::whereTenantId($tenant->id)->inRandomOrder()->first()?->id,
                        ]);

                        Need::factory()->create([
                            'tenant_id' => $tenant->id,
                            'needable_id' => $orphan->id,
                            'needable_type' => 'orphan',
                        ]);

                        Need::factory()->create([
                            'tenant_id' => $tenant->id,
                            'needable_id' => $sponsor->id,
                            'needable_type' => 'sponsor',
                        ]);
                    }

                    monthlySponsorship($family);
                }
            });
    }
}
