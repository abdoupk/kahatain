<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use Inertia\Response;

class StudentsIndexController extends Controller
{
    public function __invoke(): Response
    {
        return inertia('Tenant/students/index/StudentIndexPage', [
            'academicLevels' => getAcademicLevelsForStudentsIndex(),
            'totalStudents' => getTotalStudents(),
            'studentsPerPhase' => getStudentsPerPhase(),
        ]);
    }
}
