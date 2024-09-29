<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::select('id')->lazy(100)->each(function (Tenant $tenant) {
            Event::factory()->count(10)->create([
                'start_date' => now()->subDays(fake()->randomDigit()),
                'end_date' => now()->addDays(fake()->randomDigit()),
                'tenant_id' => $tenant->id,
                'school_id' => $tenant->schools->random()->first()->id,
            ]);
        });
    }
}
