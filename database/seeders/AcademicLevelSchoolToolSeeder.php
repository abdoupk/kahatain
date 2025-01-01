<?php

namespace Database\Seeders;

use App\Models\AcademicLevel;
use Illuminate\Database\Seeder;

class AcademicLevelSchoolToolSeeder extends Seeder
{
    private array $commonTools = [41, 51, 48, 49, 50, 29, 7, 8, 9, 10, 11, 12, 13, 32, 55, 3, 4, 56, 14, 20, 21, 22, 54, 46, 47, 34];

    private array $commonQts = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 100, 100, 1, 1, 1, 1, 1, 1, 1, 1, 1];

    public function run(): void
    {
        // primary school
        $this->primaryEducation();

        // middle school
        $this->middleEducation();

        // high school 1st year
        $this->highEducationFirstYear();

        // high school 2nd year
        $this->highEducationSecondYear();

        // high school 3rd year
        $this->highEducationThirdYear();
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
        // TODO change 31 to 13
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
        $toolIds = [44, 25, 26, 1, 28, 57, 58, 37, 45];

        $qts = [3, 4, 4, 1, 1, 1, 1, 2, 1, 1, 1];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $this->createRelationShip(AcademicLevel::whereIId(18)->first(), $toolIds, $qts);

        // 2nd Math
        $toolIds = [44, 25, 26, 1, 28, 57, 58, 37, 45];

        $qts = [3, 4, 2, 1, 1, 1, 1, 2, 1];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $this->createRelationShip(AcademicLevel::whereIId(13)->first(), $toolIds, $qts);

        // 2nd Technology
        $toolIds = [44, 25, 26, 1, 28, 37, 45];

        $qts = [3, 5, 3, 1, 1, 1, 1];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $this->createRelationShip(AcademicLevel::whereIId(14)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(15)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(16)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(17)->first(), $toolIds, $qts);

        // 2nd Economy
        $toolIds = [25, 26, 27, 28, 1, 37];

        $qts = [7, 4, 1, 1, 1, 1];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $this->createRelationShip(AcademicLevel::whereIId(19)->first(), $toolIds, $qts);

        // 2nd Philosophy
        $toolIds = [25, 26, 27, 28, 1, 57, 58, 37, 19];

        $qts = [4, 3, 2, 1, 1, 1, 1, 2, 1];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $this->createRelationShip(AcademicLevel::whereIId(20)->first(), $toolIds, $qts);

        // 2nd Languages
        $toolIds = [25, 26, 27, 28, 1, 37];

        $qts = [3, 3, 3, 1, 1, 1];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $this->createRelationShip(AcademicLevel::whereIId(21)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(22)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(23)->first(), $toolIds, $qts);
    }

    private function highEducationThirdYear(): void
    {
        // 3rd science
        $toolIds = [25, 26, 27, 28, 1, 57, 58, 45, 37];

        $qts = [6, 3, 2, 1, 1, 1, 1, 1, 2];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $this->createRelationShip(AcademicLevel::whereIId(29)->first(), $toolIds, $qts);

        // 3rd Math
        $toolIds = [25, 26, 27, 28, 1, 57, 58, 45, 37];

        $qts = [0, 0, 0, 0, 1, 1, 1, 1, 2];

        $toolIds = array_merge($toolIds, $this->commonTools);

        $qts = array_merge($qts, $this->commonQts);

        $newTools = array_slice($toolIds, 0, 1);

        $newQts = array_slice($qts, 0, 1);

        $a = array_merge($newQts, [34]);

        $b = array_merge($newTools, [2]);

        $this->createRelationShip(AcademicLevel::whereIId(24)->first(), $b, $a);

        // 3rd Technology
        $toolIds = [25, 26, 27, 28, 1, 45, 59];

        $qts = [5, 3, 3, 1, 1, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(25)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(26)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(27)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(28)->first(), $toolIds, $qts);

        // 3rd Economy
        $toolIds = [44, 25, 26, 28, 1];

        $qts = [1, 7, 4, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(11)->first(), $toolIds, $qts);

        // 3rd Languages
        $toolIds = [25, 26, 27, 28, 1];

        $qts = [3, 2, 4, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(32)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(33)->first(), $toolIds, $qts);

        $this->createRelationShip(AcademicLevel::whereIId(34)->first(), $toolIds, $qts);

        // 3rd Philosophy
        $toolIds = [44, 25, 26, 28, 1];

        $qts = [2, 4, 2, 1, 1];

        $this->createRelationShip(AcademicLevel::whereIId(31)->first(), $toolIds, $qts);
    }
}
