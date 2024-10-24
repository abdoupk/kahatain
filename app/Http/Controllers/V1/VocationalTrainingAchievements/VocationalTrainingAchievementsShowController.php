<?php

namespace App\Http\Controllers\V1\VocationalTrainingAchievements;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\VocationalTrainingAchievements\VocationalTrainingAchievementShowResource;
use App\Models\VocationalTrainingAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class VocationalTrainingAchievementsShowController extends Controller implements HasMiddleware
{
    public function __invoke(VocationalTrainingAchievement $vocationalTrainingAchievement)
    {
        return response()->json([
            'vocational_training_achievement' => new VocationalTrainingAchievementShowResource(
                $vocationalTrainingAchievement
            ),
        ]);
    }

    public static function middleware()
    {
        return ['can:update_orphans'];
    }
}
