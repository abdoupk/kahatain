<?php

namespace App\Http\Controllers\V1\CollegeStudents;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Students\PhaseStudentsIndexResource;
use App\Models\AcademicLevel;

class PhaseTraineesIndexController extends Controller
{
    public function __invoke(string $phase, AcademicLevel $academicLevel)
    {
        if (! in_array($phase, ['primary-education', 'middle-education', 'secondary-education'])) {
            abort(404);
        }

        return inertia('Tenant/students/phases/StudentsPhasePage', [
            'students' => PhaseStudentsIndexResource::collection(getPhaseStudents($academicLevel->id)),
            'params' => getParams(),
        ]);
    }
}