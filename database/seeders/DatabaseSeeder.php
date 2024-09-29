<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CitySeeder::class);

//        $this->call(PermissionSeeder::class);

        $this->call(TenantSeeder::class);

        $this->call(RolePermissionSeeder::class);

        $this->call(FamilySeeder::class);

        $this->call(IncomeSeeder::class);

        $this->call(FurnishingSeeder::class);

        $this->call(HousingSeeder::class);

        $this->call(OrphanSponsorshipSeeder::class);

        $this->call(FamilySponsorshipSeeder::class);

        $this->call(SponsorSponsorshipSeeder::class);

        $this->call(PreviewSeeder::class);

        $this->call(PrivateSchoolSeeder::class);

        //        $this->call(EventSeeder::class);
    }
}
