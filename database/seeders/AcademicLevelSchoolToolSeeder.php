<?php

namespace Database\Seeders;

use App\Models\AcademicLevel;
use Illuminate\Database\Seeder;

class AcademicLevelSchoolToolSeeder extends Seeder
{
    public function run(): void
    {
        // primary school
        $this->primaryEducation();

        //        // middle school
        //        $this->middleEducation();
        //
        //        // high school
        //        $this->highEducationFirstYear();
        //
        //        $this->highEducationSecondYear();
        //
        //        $this->highEducationThirdYear();
    }

    public function createRelationShip(AcademicLevel $academicLevel, array $toolIds, array $qts): void
    {
        $data = collect($toolIds)->map(function ($id, $index) use ($qts) {
            return [
                'school_tool_id' => $id,
                'qty' => $qts[$index] ?? 1, // Default to 1 if qty is not set
            ];
        })->all();

        $academicLevel->AcademicLevelSchoolTools()->createMany($data);
    }

    public function middleEducation(): void
    {
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(7)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(8)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(9)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(10)->first(), $toolIds, $qts);
    }

    public function primaryEducation(): void
    {
        // 1st and 2nd Academic Level
        $toolIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19];

        $qts = [2, 1, 3, 8, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(2)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(3)->first(), $toolIds, $qts);

        // 3rd Academic Level
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21];

        $qts = [8, 3, 11, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(4)->first(), $toolIds, $qts);

        // 4th and 5th Academic Level
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [10, 3, 13, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(5)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(6)->first(), $toolIds, $qts);
    }

    public function highEducationFirstYear(): void
    {
        // 1st science
        $toolIds = [1, 26, 54, 65, 66, 39, 27, 28, 55, 56, 1, 50, 59, 57, 58, 29, 60, 61, 7];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(12)->first(), $toolIds, $qts);

        // 1st literature
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);
    }

    private function highEducationSecondYear(): void
    {
        // 2nd science
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Math
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Technology
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Economy
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Philosophy
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Languages
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);
    }

    private function highEducationThirdYear(): void
    {
        // 3rd science
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Math
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Technology
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Economy
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Philosophy
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Languages
        $toolIds = [1, 20, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 21, 22, 23];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);
    }
}
