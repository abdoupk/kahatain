<?php

namespace App\Http\Controllers\V1\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MonthlySponsorship\MonthlySponsorshipResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class FamiliesMonthlySponsorshipIndexController extends Controller implements HasMiddleware
{
    public function __invoke()
    {
        return Inertia::render('Tenant/occasions/monthly-sponsorship/MonthlySponsorshipIndex', [
            'families' => MonthlySponsorshipResource::collection(listOfFamiliesBenefitingFromTheMonthlySponsorship()),
            'params' => getParams(),
            'archive' => [],
        ]);
    }

    public static function middleware()
    {
        return ['can:view_monthly_sponsorships'];
    }
}
