<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SponsorsStatisticsController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/sponsors/statistics/SponsorsStatisticsPage', [
            'sponsorsBySponsorType' => getSponsorsBySponsorType(),
            'sponsorsByAcademicLevel' => getSponsorsByAcademicLevel(),
            'sponsorsBySponsorship' => getSponsorsBySponsorship(),
            'sponsorsByDiploma' => getSponsorsByDiploma(),
        ]);
    }
}
