<?php

namespace Database\Seeders;

use Artisan;
use DB;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use JsonException;
use Str;

class SchoolSeeder extends Seeder
{
    /**
     * @throws FileNotFoundException
     * @throws JsonException
     */
    public function run(): void
    {
        $schools = json_decode(File::get(database_path('data/schools.json')), true, 512, JSON_THROW_ON_ERROR);

        DB::table('schools')->insert(array_map(static function ($school) {
            return [
                'id' => Str::uuid(),
                'name' => $school['name'],
                'phase_key' => $school['phase_key'],
                'city_id' => $school['city_id'],
                'e_id' => $school['e_id'],
                'created_at' => $school['created_at'],
                'updated_at' => $school['updated_at'],
            ];
        }, $schools));

        Artisan::call('scout:import', ['model' => 'App\Models\School']);
    }
}
