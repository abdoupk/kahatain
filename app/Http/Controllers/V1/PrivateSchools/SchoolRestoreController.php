<?php

namespace App\Http\Controllers\V1\PrivateSchools;

use App\Http\Controllers\Controller;
use App\Models\PrivateSchool;
use Illuminate\Routing\Controllers\HasMiddleware;

class SchoolRestoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:restore_trash'];
    }

    public function __invoke(PrivateSchool $school)
    {
        $school->restore();

        return redirect()->back();
    }
}
