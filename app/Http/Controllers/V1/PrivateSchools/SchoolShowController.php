<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Schools\SchoolResource;
use App\Models\PrivateSchool;
use Illuminate\Routing\Controllers\HasMiddleware;

class SchoolShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_schools'];
    }

    public function __invoke(PrivateSchool $school)
    {
        return response()->json([
            'school' => SchoolResource::make($school->load(['lessons.academicLevel', 'lessons.subject'])),
        ]);
    }
}
