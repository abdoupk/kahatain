<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Students\PhaseStudentsIndexResource;
use App\Models\AcademicLevel;
use Illuminate\Routing\Controllers\HasMiddleware;

class PhaseStudentsIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_transcripts_students'];
    }

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
