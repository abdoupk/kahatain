<?php

namespace App\Http\Controllers\V1\Occasions\MeatDistribution;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\MeatDistributionResource;
use Inertia\Inertia;
use Inertia\Response;

class FamiliesMeatDistributionIndexController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/occasions/meat-distribution/MeatDistributionIndex', [
            'families' => MeatDistributionResource::collection(listOfFamiliesBenefitingFromTheMeatDistributionSponsorship()),
            'params' => getParams(),
        ]);
    }
}
