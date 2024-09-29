<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::with('members')->each(function (Tenant $tenant) {
            setPermissionsTeamId($tenant->id);
            $tenant->members->each(function (User $user, $key) use ($tenant) {
//                if ($key === 1) {
//                    $role = Role::create(['name' => 'vice_president', 'tenant_id' => $tenant->id]);
//                } else {
//                    $role = Role::firstOrCreate([
//                        'tenant_id' => $tenant->id,
//                        'name' => 'member',
//                    ]);
//                }
//
//                $user->assignRole($role);
            });
        });
    }
}
