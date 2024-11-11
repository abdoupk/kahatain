<?php

namespace App\Http\Controllers\V1\VocationalTrainingAchievements;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\VocationalTrainingAchievements\VocationalTrainingAchievementsCreateRequest;
use App\Models\VocationalTrainingAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class VocationalTrainingAchievementsStoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_orphans'];
    }

    public function __invoke(VocationalTrainingAchievementsCreateRequest $request)
    {
        VocationalTrainingAchievement::create($request->validated());

        return response('', 201);
    }
}
