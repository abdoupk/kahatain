<?php

namespace App\Http\Controllers\V1\AcademicAchievements;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AcademicAchievements\AcademicAchievementsCreateRequest;
use App\Jobs\V1\Orphan\OrphanUpdatedJob;
use App\Models\AcademicAchievement;
use Illuminate\Routing\Controllers\HasMiddleware;

class AcademicAchievementsStoreController extends Controller implements HasMiddleware
{
    public function __invoke(AcademicAchievementsCreateRequest $request)
    {
        $academicAchievement = AcademicAchievement::create($request->validated());

        $academicAchievement->orphan->searchable();

        dispatch(new OrphanUpdatedJob($academicAchievement->orphan, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return [
            'can:update_orphans',
        ];
    }
}
