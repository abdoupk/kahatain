<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class FamiliesStatisticsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/families/statistics/FamiliesStatisticsPage', [
            'familiesByZone' => fn () => getFamiliesGroupedByZone(),
            'familiesByBranch' => fn () => getFamiliesGroupedByBranch(),
            'familiesByOrphansCount' => fn () => getFamiliesGroupedByOrphansCount(),
            'familiesHousing' => fn () => getFamiliesHousingTypes(),
            'familiesGroupByDate' => fn () => getFamiliesGroupByDate(),
        ]);
    }
}
