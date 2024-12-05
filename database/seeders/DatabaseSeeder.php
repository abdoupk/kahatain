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

        //        $this->call(SchoolSeeder::class);

        //        $this->call(UniversitySeeder::class);

        //        $this->call(SchoolToolSeeder::class);

        //        $this->call(VocationalTrainingCenterSeeder::class);

        $this->call(SubjectSeeder::class);

        $this->call(AcademicLevelSeeder::class);

        $this->call(TenantSeeder::class);

        $this->call(PermissionSeeder::class);

        $this->call(BenefactorSeeder::class);

        $this->call(FamilySeeder::class);

        $this->call(FurnishingSeeder::class);

        $this->call(PreviewSeeder::class);

        $this->call(PrivateSchoolSeeder::class);

        Artisan::call('scout:sync-index-settings');

        Artisan::call('scout:import', ['model' => 'App\Models\VocationalTraining']);

        Artisan::call('generate:locales');
    }
}
