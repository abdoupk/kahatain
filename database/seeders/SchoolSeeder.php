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
        // Decode JSON file in manageable chunks
        $filePath = database_path('data/schools.json');
        $schools = json_decode(File::get($filePath), true, 512, JSON_THROW_ON_ERROR);

        $batchSize = 1000; // Adjust batch size as needed
        $batches = array_chunk($schools, $batchSize);

        foreach ($batches as $batch) {
            $data = array_map(static function ($school) {
                if ($school['phase_key'] === 'middle_school') {
                    $school['phase_key'] = 'middle_education';
                } elseif ($school['phase_key'] === 'high_school') {
                    $school['phase_key'] = 'secondary_education';
                } elseif ($school['phase_key'] === 'elementary_school') {
                    $school['phase_key'] = 'primary_education';
                }

                return [
                    'id' => Str::uuid(),
                    'name' => $school['name'],
                    'phase_key' => $school['phase_key'],
                    'city_id' => $school['city_id'],
                    'e_id' => $school['e_id'],
                    'created_at' => $school['created_at'],
                    'updated_at' => $school['updated_at'],
                ];
            }, $batch);

            DB::table('schools')->insert($data);

            Artisan::call('scout:import', ['model' => 'App\Models\School']);
        }
    }
}
