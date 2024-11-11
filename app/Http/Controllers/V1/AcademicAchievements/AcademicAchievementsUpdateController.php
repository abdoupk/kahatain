<?php

namespace App\Http\Controllers\V1\AcademicAchievements;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AcademicAchievements\AcademicAchievementsUpdateRequest;
use App\Jobs\V1\Orphan\OrphanUpdatedJob;
use App\Models\AcademicAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class AcademicAchievementsUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:update_orphans',
        ];
    }

    public function __invoke(AcademicAchievementsUpdateRequest $request, AcademicAchievement $academicAchievement)
    {
        $academicAchievement->update($request->validated());

        $academicAchievement->orphan->searchable();

        dispatch(new OrphanUpdatedJob($academicAchievement->orphan, auth()->user()));

        return response('', 201);
    }
}
