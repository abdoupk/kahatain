<?php

namespace App\Http\Controllers\V1\Occasions\Zakat;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\ZakatResource;
use Inertia\Inertia;
use Inertia\Response;

class FamiliesZakatIndexController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/occasions/zakat/ZakatIndex', [
            'families' => ZakatResource::collection(listOfFamiliesBenefitingFromTheZakatSponsorship()),
            'params' => getParams(),
        ]);
    }
}
