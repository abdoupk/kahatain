<?php

namespace Database\Seeders;

use App\Models\AcademicLevelSchoolTool;
use Illuminate\Database\Seeder;

class AcademicLevelSchoolToolSeeder extends Seeder
{
    public function run(): void
    {
        AcademicLevelSchoolTool::insert([
            [
                'academic_level_id' => 1,
                'school_tool_id' => 1,
                'qty' => 1,
                'min_price' => 1,
                'max_price' => 1,
            ],
        ]);
    }
}
