<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\V1\Schools\SchoolsIndexResource;
use App\Models\Subject;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class SchoolsIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_schools'];
    }

    public function __invoke()
    {
        return Inertia::render('Tenant/schools/index/SchoolsIndexPage', [
            'schools' => fn () => SchoolsIndexResource::collection(getSchools()),
            'subjects' => fn () => SubjectResource::collection(Subject::all()),
            'params' => getParams(),
        ]);
    }
}
