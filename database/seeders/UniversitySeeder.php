<?php

namespace Database\Seeders;

use Artisan;
use DB;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use JsonException;
use Str;

class UniversitySeeder extends Seeder
{
    /**
     * @throws JsonException
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $universities = json_decode(File::get(database_path('data/universities.json')), true, 512, JSON_THROW_ON_ERROR);

        DB::table('universities')->insert(array_map(static function ($university) {
            return [
                'id' => Str::uuid(),
                'name' => trim($university['name']),
                'zone' => $university['zone'],
                'type' => $university['type'],
            ];
        }, $universities));

        Artisan::call('scout:import', ['model' => 'App\\Models\\University']);
    }
}
