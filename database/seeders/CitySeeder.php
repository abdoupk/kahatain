<?php

namespace Database\Seeders;

use Artisan;
use DB;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use JsonException;

class CitySeeder extends Seeder
{
    /**
     * @throws FileNotFoundException
     * @throws JsonException
     */
    public function run(): void
    {
        $jsonPath = database_path('data/cities.json');
        $cities = json_decode(File::get($jsonPath), true, 512, JSON_THROW_ON_ERROR);

        DB::table('cities')->insert(array_map(static function ($city) {
            return [
                'id' => $city['id'],
                'commune_name' => $city['commune_name'],
                'commune_name_ascii' => $city['commune_name_ascii'],
                'daira_name' => $city['daira_name'],
                'daira_name_ascii' => $city['daira_name_ascii'],
                'latitude' => $city['latitude'],
                'longitude' => $city['longitude'],
                'post_code' => $city['post_code'],
                'wilaya_code' => $city['wilaya_code'],
                'wilaya_name' => $city['wilaya_name'],
                'wilaya_name_ascii' => $city['wilaya_name_ascii'],
            ];
        }, $cities));

        Artisan::call('scout:import', ['model' => 'App\\Models\\City']);
    }
}
