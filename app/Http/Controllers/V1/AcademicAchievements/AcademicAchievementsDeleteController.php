<?php

namespace App\Http\Controllers\V1\AcademicAchievements;

use App\Http\Controllers\Controller;
use App\Models\AcademicAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class AcademicAchievementsDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:update_orphans',
        ];
    }

    public function __invoke(AcademicAchievement $academicAchievement)
    {
        $academicAchievement->delete();

        return redirect()->back();
    }
}
