<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Models\PrivateSchool;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class SchoolForceDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(PrivateSchool $school): Response
    {
        $school->forceDelete();

        return response('', 204);
    }

    public static function middleware()
    {
        return ['can:destroy_trash'];
    }
}
