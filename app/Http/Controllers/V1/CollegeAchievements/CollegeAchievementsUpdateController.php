<?php

namespace App\Http\Controllers\V1\CollegeAchievements;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CollegeAchievements\CollegeAchievementsUpdateRequest;
use App\Jobs\V1\Orphan\OrphanUpdatedJob;
use App\Models\CollegeAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class CollegeAchievementsUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_orphans'];
    }

    public function __invoke(CollegeAchievementsUpdateRequest $request, CollegeAchievement $collegeAchievement)
    {
        $collegeAchievement->update($request->validated());

        $collegeAchievement->orphan->searchable();

        dispatch(new OrphanUpdatedJob($collegeAchievement->orphan, auth()->user()));

        return response('', 201);
    }
}
