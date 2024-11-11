<?php

namespace App\Http\Controllers\V1\CollegeAchievements;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Orphans\CollegeAchievementResource;
use App\Models\CollegeAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class CollegeAchievementsShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_orphans'];
    }

    public function __invoke(CollegeAchievement $collegeAchievement)
    {
        return response()->json([
            'college_achievement' => new CollegeAchievementResource($collegeAchievement->load('academicLevel')),
        ]);
    }
}
