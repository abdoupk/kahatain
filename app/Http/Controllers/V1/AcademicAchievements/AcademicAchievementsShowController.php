<?php

namespace App\Http\Controllers\V1\AcademicAchievements;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AcademicAchievements\AcademicAchievementResource;
use App\Models\AcademicAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class AcademicAchievementsShowController extends Controller implements HasMiddleware
{
    public function __invoke(AcademicAchievement $academicAchievement)
    {
        return response()->json([
            'academic_achievement' => new AcademicAchievementResource($academicAchievement),
        ]);
    }

    public static function middleware()
    {
        return [
            'can:view_orphans',
        ];
    }
}
