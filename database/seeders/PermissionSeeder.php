<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->setPermissionsTeamId(tenant('id'));

        $permissions = [
            'roles' => ['create', 'delete', 'list', 'update'],
            'members' => ['create', 'delete', 'list', 'update', 'view'],
            'branches' => ['create', 'delete', 'list', 'update', 'view'],
            'families' => ['create', 'delete', 'export', 'list', 'update', 'view'],
            'orphans' => ['delete', 'export', 'list', 'update', 'view'],
            'sponsors' => ['delete', 'export', 'list', 'update', 'view'],
            'zones' => ['create', 'delete', 'list', 'update', 'view'],
            'financial_transactions' => ['create', 'delete', 'export', 'list', 'update', 'view'],
            'settings' => ['update', 'view'],
            'needs' => ['create', 'delete', 'list', 'update', 'view'],
            'schools' => ['create', 'delete', 'list', 'update', 'view'],
            'lessons' => ['create', 'delete', 'list', 'update', 'view'],
            'committees' => ['create', 'delete', 'list', 'update', 'view'],
            'benefactors' => ['create', 'delete', 'list', 'update', 'view'],
            'sponsorships' => ['create'],
            'monthly_sponsorships' => ['update_settings'],
            'archive' => ['export', 'list', 'view'],
            'trash' => ['destroy', 'list', 'restore'],
            'occasions' => ['save', 'view', 'export'],
            'transcripts' => ['create', 'delete', 'list', 'update', 'view'],
            'students' => ['list'],
        ];

        $inventoryPermissions = ['add_to_inventory', 'delete_from_inventory', 'list_items', 'update_inventory', 'view_item'];

        foreach ($permissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::create(['name' => $permission.'_'.$key, 'guard_name' => 'web']);
            }
        }

        foreach ($inventoryPermissions as $item) {
            Permission::create(['name' => $item, 'guard_name' => 'web']);
        }
    }
}
