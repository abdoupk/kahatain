<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        //        $vicePresident = Role::create(['name' => 'vice_president']);

        //        $officeMember = Role::create(['name' => 'office_member']);

        //        $member = Role::create(['name' => 'member']);

        //        $areaChief = Role::create(['name' => 'area_chief']);

        //        $assistantAreaChief = Role::create(['name' => 'assistant_area_chief']);

        //        //        Role::create(['name' => 'president']);

        Role::create(['name' => 'super_admin']);
    }
}
