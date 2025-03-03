<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Committee;
use App\Models\Competence;
use App\Models\Domain;
use App\Models\Finance;
use App\Models\Inventory;
use App\Models\MonthlyBasket;
use App\Models\RamadanBasket;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::factory()->create([
            'infos' => [
                'super_admin' => [
                    'first_name' => 'Rezig',
                    'last_name' => 'Chikh',
                    'password' => 'password',
                    'email' => 'test@example.com',
                ],
                'domain' => 'foo.'.config('app.domain'),
                'association' => 'kafil el yatim El-bayadh ',
                'city_id' => 1144,
                'city' => [
                    'id' => 1144,
                    'daira_name' => 'البيض',
                    'wilaya_code' => '32',
                    'wilaya_name' => 'البيض',
                ],
            ],
        ]);

        $tenant2 = Tenant::factory()->create([
            'infos' => [
                'super_admin' => [
                    'first_name' => 'Rezig',
                    'last_name' => 'Abderrahmane',
                    'email' => 'test@example.com',
                    'password' => 'password',
                ],
                'domain' => 'bar.'.config('app.domain'),
                'association' => 'kafil el yatim El-bayadh 02',
                'city_id' => 1144,
                'city' => [
                    'id' => 1144,
                    'daira_name' => 'البيض',
                    'wilaya_code' => '32',
                    'wilaya_name' => 'البيض',
                ],
            ],
        ]);

        //        $tenants = Tenant::factory(5)->create();
        $tenants[] = $tenant1;
        $tenants[] = $tenant2;

        foreach ($tenants as $tenant) {
            Domain::factory()->create([
                'tenant_id' => $tenant?->id,
                'domain' => $tenant?->infos['domain'],
            ]);

            User::factory()
                ->hasAttached(
                    Competence::factory()->count(
                        fake()->numberBetween(1, 3)
                    )->create([
                        'tenant_id' => $tenant?->id,
                    ]),
                    ['tenant_id' => $tenant?->id]
                )
                ->hasAttached(Committee::factory(
                    fake()->numberBetween(0, 3)
                )->create([
                    'tenant_id' => $tenant?->id,
                ]),
                    ['tenant_id' => $tenant?->id]
                )
                ->count(10)
                ->create([
                    'tenant_id' => $tenant?->id,
                ]);

            Zone::factory()->count(10)->create(
                [
                    'tenant_id' => $tenant->id,
                    'created_by' => $tenant->members->random()->first()?->id,
                ]);

            competence::factory()->count(10)->create(['tenant_id' => $tenant->id]);

            Branch::factory(fake()->numberBetween(1, 12))->create([
                'tenant_id' => $tenant?->id,
                'president_id' => $tenant->members->random()->first()?->id,
            ]);

            for ($i = 0; $i < fake()->numberBetween(3, 13); $i++) {
                RamadanBasket::factory()
                    ->for(Inventory::factory()->state([
                        'tenant_id' => $tenant->id,
                        'created_by' => $tenant->members->random()->first()->id,
                    ]))
                    ->create(['tenant_id' => $tenant->id]);

                MonthlyBasket::factory()
                    ->for(Inventory::factory()->state([
                        'tenant_id' => $tenant->id,
                        'created_by' => $tenant->members->random()->first()->id,
                    ]))
                    ->create(['tenant_id' => $tenant->id]);
            }

            Finance::factory()->count(fake()->numberBetween(13, 89))->create([
                'tenant_id' => $tenant->id,
                'created_by' => $tenant->members->random()->first()->id,
                'received_by' => $tenant->members->random()->first()->id,
            ]);
        }
    }
}
