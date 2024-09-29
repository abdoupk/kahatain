<?php

namespace App\Http\Controllers\V1\CollegeAchievements;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CollegeAchievements\CollegeAchievementsCreateRequest;
use App\Models\CollegeAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class CollegeAchievementsStoreController extends Controller implements HasMiddleware
{
    public function __invoke(CollegeAchievementsCreateRequest $request)
    {
        CollegeAchievement::create($request->validated());

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:update_orphans'];
    }
}
