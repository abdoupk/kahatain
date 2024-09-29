<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Schools\SchoolShowResource;
use App\Models\PrivateSchool;
use Illuminate\Routing\Controllers\HasMiddleware;

class SchoolDetailsController extends Controller implements HasMiddleware
{
    public function __invoke(PrivateSchool $school)
    {
        return response()->json([
            'school' => SchoolShowResource::make(
                $school->load(
                    ['creator:id,first_name,last_name']
                )->loadCount('lessons')
            ),
        ]);
    }
    public static function middleware()
    {
        return ['can:view_schools'];
    }
}
