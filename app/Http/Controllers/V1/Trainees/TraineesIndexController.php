<?php

namespace App\Http\Controllers\V1\Trainees;

use App\Http\Controllers\Controller;
use Inertia\Response;

class TraineesIndexController extends Controller
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
}
