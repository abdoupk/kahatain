<?php

namespace App\Http\Controllers\V1\VocationalTrainingAchievements;

use App\Http\Controllers\Controller;
use App\Models\VocationalTrainingAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class VocationalTrainingAchievementsDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(VocationalTrainingAchievement $vocationalTrainingAchievement)
    {
        $vocationalTrainingAchievement->delete();

        return redirect()->back();
    }
    public static function middleware()
    {
        return ['can:update_orphans'];
    }
}
