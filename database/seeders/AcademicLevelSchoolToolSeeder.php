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

        // middle school
        $this->middleEducation();

        // high school
        $this->highEducationFirstYear();

        //        $this->highEducationSecondYear();

        //        $this->highEducationThirdYear();
    }

    public function createRelationShip(AcademicLevel $academicLevel, array $toolIds, array $qts): void
    {
        $toolIds = array_merge($toolIds, [52, 53]);
        $qts = array_merge($qts, [1, 1]);

        $data = collect($toolIds)->map(function ($id, $index) use ($qts) {
            return [
                'school_tool_id' => $id,
                'qty' => $qts[$index] ?? 1, // Default to 1 if qty is not set
            ];
        })->all();

        $academicLevel->AcademicLevelSchoolTools()->createMany($data);
    }

    public function primaryEducation(): void
    {
        // 1st and 2nd Academic Level
        $toolIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18];

        $qts = [2, 1, 3, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(2)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(3)->first(), $toolIds, $qts);

        // 3rd Academic Level
        $toolIds = [1, 19, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 20];

        $qts = [8, 3, 8, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(4)->first(), $toolIds, $qts);

        // 4th Academic Level
        $toolIds = [1, 19, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 20, 21, 22];

        $qts = [10, 3, 13, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(5)->first(), $toolIds, $qts);

        // 5th Academic Level
        $qts = [8, 3, 11, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(6)->first(), $toolIds, $qts);
    }

    public function middleEducation(): void
    {
        //TODO change 31 to 13
        $toolIds = [25, 23, 1, 26, 28, 24, 29, 3, 4, 30, 8, 9, 10, 11, 12, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43];

        $qts = [2, 2, 4, 4, 3, 2, 1, 100, 100, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(7)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(8)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(9)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(10)->first(), $toolIds, $qts);
    }

    public function highEducationFirstYear(): void
    {
        // 1st science
        // TODO change 13 to 31
        $toolIds = [27, 25, 26, 1, 28, 45, 57, 58, 37, 56, 46, 47, 41, 51, 48, 49, 50, 29, 7, 8, 9, 10, 11, 12, 13, 32, 55, 3, 4, 34, 56, 14, 20, 21, 22, 54];

        $qts = [2, 5, 6, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1,
            1, 1, 1, 1, 1, 1, 1, 1, 1, 100, 100, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(12)->first(), $toolIds, $qts);

        // 1st literature
        $toolIds = [27, 26, 25, 1, 19, 28, 46, 47, 37, 7, 8, 9, 10, 11, 12, 13, 32, 55, 3, 4, 34, 56, 14, 20, 21, 22, 54];

        $qts = [1, 8, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 100, 100, 1, 1, 1, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);
    }

    private function highEducationSecondYear(): void
    {
        // 2nd science
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Math
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Technology
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Economy
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Philosophy
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 2nd Languages
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);
    }

    private function highEducationThirdYear(): void
    {
        // 3rd science
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Math
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Technology
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Economy
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Philosophy
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Languages
        $toolIds = [];

        $qts = [];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);
    }
}
