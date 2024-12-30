<?php

namespace App\Http\Controllers\V1\Trainees;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Response;

class TraineesIndexController extends Controller implements HasMiddleware
{
    public function __invoke(): Response
    {
        return inertia('Tenant/trainees/index/TraineesIndex', [
            'academicLevels' => fn () => getAcademicLevelsForTraineesIndex(),
            'totalTrainees' => fn () => getTotalTrainees(),
            'traineesPerPhase' => fn () => getTraineesPerPhase(),
            'traineesPerInstitution' => fn () => getTraineesPerVocationalTrainingCenter(),
        ]);
    }

    public static function middleware()
    {
        return ['can:list_trainees'];
    }
}
