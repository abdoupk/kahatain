<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MonthlySponsorship\MonthlySponsorshipResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class FamiliesMonthlySponsorshipIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_occasions'];
    }

    public function __invoke(): Response
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
