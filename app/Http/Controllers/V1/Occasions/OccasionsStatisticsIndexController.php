<?php

namespace App\Http\Controllers\V1\Occasions;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Inertia\Response;

class OccasionsStatisticsIndexController extends Controller
{
    public function __invoke(): Response
    {
        ray(getStatisticsForRamadanBasket());

        return inertia()->render('Tenant/occasions/statistics/index/StatisticsIndexPage',
            [
                'babiesMilkAndDiapers' => fn () => getStatisticsForBabiesMilkAndDiaper(),
                'ramadanBasket' => fn () => getStatisticsForRamadanBasket(),
                'eidSuit' => fn () => getStatisticsForEidSuit(),
                'eidAlAdha' => fn () => getStatisticsForEidAlAdha(),
                'schoolEntry' => fn () => getStatisticsForSchoolEntry(),
                'monthlySponsorship' => fn () => getStatisticsForMonthlySponsorship(),
                'zakat' => fn () => getStatisticsForZakat(),
                'meatDistribution' => fn () => getStatisticsForMeatDistribution(),
                'minMaxDate' => fn () => $this->getMinMaxDate(),
            ]);
    }

    private function getMinMaxDate()
    {
        $result = Archive::selectRaw('MIN(EXTRACT(YEAR FROM created_at)) as min_year, MAX(EXTRACT(YEAR FROM created_at)) as max_year')->first();

        return [
            'min_year' => (int) $result->min_year,
            'max_year' => (int) $result->max_year,
        ];
    }
}
