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
            'benefactors' => ['create', 'delete', 'list', 'update', 'view', 'add_new_sponsorship'],
            'sponsorships' => ['create'],
            'monthly_sponsorships' => ['update_settings'],
            'archive' => ['export', 'list', 'view'],
            'trash' => ['destroy', 'list', 'restore'],
            'occasions' => ['save', 'view', 'export'],
            'transcripts' => ['create', 'delete', 'list', 'update', 'view'],
            'college_students' => ['list'],
            'trainees_orphans' => ['list'],
        ];

        $additionalPermissions = [
            'inventory' => ['add_to_inventory', 'delete_from_inventory', 'list_items', 'update_inventory', 'view_item'],
            'students' => ['list_students', 'start_new_academic_year', 'export_school_supplies', 'view_transcripts_students'],
        ];

        // Combine all permissions into one array
        $allPermissions = array_merge($permissions, $additionalPermissions);

        // Create permissions
        foreach ($allPermissions as $key => $value) {
            foreach ($value as $permission) {
                Permission::create(['name' => $permission.($key !== 'inventory' && $key !== 'students' ? '_'.$key : ''), 'guard_name' => 'web']);
            }
        }
    }
}
