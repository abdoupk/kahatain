<?php

namespace App\Http\Controllers\V1\CollegeStudents;

use App\Http\Controllers\Controller;
use Inertia\Response;

class CollegeStudentsIndexController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Tenant/students/index/StudentIndexPage', [
            'academicLevels' => fn () => getAcademicLevelsForStudentsIndex(),
            'totalStudents' => fn () => getTotalStudents(),
            'studentsPerPhase' => fn () => getStudentsPerPhase(),
            'studentsPerSchool' => fn () => getStudentsPerSchool(),
        ]);
    }
}
