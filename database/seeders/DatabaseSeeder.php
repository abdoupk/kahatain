<?php

namespace Database\Seeders;

use Artisan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('scout:delete-all-indexes');

        $this->call(CitySeeder::class);

        $this->call(TenantSeeder::class);

        $this->call(PermissionSeeder::class);

        $this->call(BenefactorSeeder::class);

        $this->call(FamilySeeder::class);

        $this->call(FurnishingSeeder::class);

        $this->call(PreviewSeeder::class);

        $this->call(PrivateSchoolSeeder::class);

        Artisan::call('scout:sync-index-settings');
    }
}
