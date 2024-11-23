<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Students\PhaseStudentsIndexResource;
use App\Models\AcademicLevel;

class PhaseStudentsIndexController extends Controller
{
    public function __invoke(string $phase, AcademicLevel $academicLevel)
    {
        if (! in_array($phase, ['elementary', 'middle', 'high'])) {
            abort(404);
        }

        return inertia('Tenant/students/phases/StudentsPhasePage', [
            'students' => PhaseStudentsIndexResource::collection(getPhaseStudents($academicLevel->id)),
            'params' => getParams(),
        ]);
    }
}
