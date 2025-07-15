<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Students\StudentsIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Response;

class StudentsIndexController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['can:list_students'];
    }

    public function __invoke(): Response
    {
        return inertia('Tenant/students/index/StudentIndexPage', [
            'academicLevels' => fn () => getAcademicLevelsForStudentsIndex(),
            'totalStudents' => fn () => getTotalStudents(),
            'studentsPerPhase' => fn () => getStudentsPerPhase(),
            'studentsPerSchool' => fn () => getStudentsPerSchool(),
            'orphans' => fn () => StudentsIndexResource::collection(getStudents()),
            'params' => getParams(),
        ]);
    }
}
