<?php

namespace App\Http\Controllers\V1\Occasions\MeatDistribution;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\MeatDistributionResource;
use Inertia\Inertia;

class FamiliesMeatDistributionIndexController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Tenant/occasions/meat-distribution/MeatDistributionIndex', [
            'families' => MeatDistributionResource::collection(listOfFamiliesBenefitingFromTheMeatDistributionSponsorship()),
            'params' => getParams(),
        ]);
    }
}
