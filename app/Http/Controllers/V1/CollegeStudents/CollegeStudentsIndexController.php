<?php

namespace App\Http\Controllers\V1\CollegeStudents;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CollegeStudents\CollegeStudentsIndexResource;
use Inertia\Response;

class CollegeStudentsIndexController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Tenant/college-students/index/CollegeStudentsIndex', [
            'orphans' => fn () => CollegeStudentsIndexResource::collection(getCollegeStudents()),
            'params' => getParams(),
            'academicLevels' => fn () => getAcademicLevelsForCollegeStudentsIndex(),
            'totalCollegeStudents' => fn () => getTotalCollegeStudents(),
            'collegeStudentsPerPhase' => fn () => getCollegeStudentsPerPhase(),
            'studentsPerUniversity' => fn () => getCollegeStudentsPerUniversity(),
        ]);
    }
}
