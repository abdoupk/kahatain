<?php

namespace App\Http\Controllers\V1\CollegeAchievements;

use App\Http\Controllers\Controller;
use App\Models\CollegeAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class CollegeAchievementsDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_orphans'];
    }

    public function __invoke(CollegeAchievement $collegeAchievement)
    {
        $collegeAchievement->delete();

        return redirect()->back();
    }
}
