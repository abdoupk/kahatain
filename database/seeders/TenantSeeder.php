<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Domain;
use App\Models\Finance;
use App\Models\Inventory;
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

            $zones = Zone::factory()->count(10)->create(['tenant_id' => $tenant->id]);

            $branches = Branch::factory(fake()->numberBetween(1, 12))->create([
                'tenant_id' => $tenant?->id,
                'president_id' => $tenant->members->random()->first()->id,
            ]);

            User::factory(10)->create([
                'tenant_id' => $tenant?->id,
                'branch_id' => $branches->random()?->id,
                'zone_id' => $zones->random()?->id,
            ]);

            Inventory::factory()->count(fake()->numberBetween(10, 25))->create([
                'tenant_id' => $tenant?->id,
                'deleted_by' => $tenant->members->random()->first()->id,
                'created_by' => $tenant->members->random()->first()->id,
            ]);

            Finance::factory()->count(fake()->numberBetween(13, 89))->create([
                'tenant_id' => $tenant->id,
                'created_by' => $tenant->members->random()->first()->id,
                'received_by' => $tenant->members->random()->first()->id,
            ]);
        }
    }
}
