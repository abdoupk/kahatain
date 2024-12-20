<?php

namespace App\Http\Controllers\V1\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MonthlySponsorship\MonthlySponsorshipResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class FamiliesMonthlySponsorshipIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_monthly_sponsorships'];
    }

    public function __invoke()
    {
        return Inertia::render('Tenant/occasions/monthly-sponsorship/MonthlySponsorshipIndex', [
            'families' => MonthlySponsorshipResource::collection(listOfFamiliesBenefitingFromTheMonthlySponsorship()),
            'params' => getParams(),
            'archive' => fn () => Archive::with('savedBy:id,first_name,last_name')->whereOccasion('monthly_sponsorship')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)->select(['id', 'saved_by', 'created_at'])->first(),
        ]);
    }
}
