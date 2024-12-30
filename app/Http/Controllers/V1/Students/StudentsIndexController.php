<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Response;

class StudentsIndexController extends Controller implements HasMiddleware
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

    public static function middleware()
    {
        return ['can:list_students'];
    }
}
