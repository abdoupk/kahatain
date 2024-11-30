<?php

namespace Database\Seeders;

use Artisan;
use DB;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use JsonException;
use Str;

class VocationalTrainingCenterSeeder extends Seeder
{
    /**
     * @throws FileNotFoundException
     * @throws JsonException
     */
    public function run(): void
    {

        $vocationalTrainingCenters = json_decode(File::get(database_path('data/vocational_training_centers.json')), true, 512, JSON_THROW_ON_ERROR);

        DB::table('vocational_training_centers')->insert(array_map(static function ($vocationalTrainingCenter) {
            return [
                'id' => Str::uuid(),
                'code' => $vocationalTrainingCenter['code'],
                'e_id' => $vocationalTrainingCenter['e_id'],
                'latin_name' => $vocationalTrainingCenter['latin_name'],
                'arabic_name' => $vocationalTrainingCenter['arabic_name'],
                'wilaya_code' => $vocationalTrainingCenter['wilaya_code'],
                'created_at' => $vocationalTrainingCenter['created_at'],
                'updated_at' => $vocationalTrainingCenter['updated_at'],
            ];
        }, $vocationalTrainingCenters));

        Artisan::call('scout:import', ['model' => 'App\Models\VocationalTrainingCenter']);

    }
}
