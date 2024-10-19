<?php

namespace App\Http\Controllers\V1\VocationalTrainingAchievements;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\VocationalTrainingAchievements\VocationalTrainingAchievementsUpdateRequest;
use App\Jobs\V1\Orphan\OrphanUpdatedJob;
use App\Models\VocationalTrainingAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class VocationalTrainingAchievementsUpdateController extends Controller implements HasMiddleware
{
    public function __invoke(
        VocationalTrainingAchievementsUpdateRequest $request,
        VocationalTrainingAchievement $vocationalTrainingAchievement
    ) {
        $vocationalTrainingAchievement->update($request->validated());

        $vocationalTrainingAchievement->orphan->searchable();

        dispatch(new OrphanUpdatedJob($vocationalTrainingAchievement->orphan, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:update_orphans'];
    }
}
