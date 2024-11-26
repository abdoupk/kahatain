<?php

namespace App\Http\Controllers\V1\Occasions\Zakat;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\ZakatResource;
use App\Models\Archive;
use Inertia\Inertia;

class FamiliesZakatIndexController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Tenant/occasions/zakat/ZakatIndex', [
            'families' => ZakatResource::collection(listOfFamiliesBenefitingFromTheZakatSponsorship()),
            'params' => getParams(),
            'archive' => fn () => Archive::with('savedBy:id,first_name,last_name')->whereOccasion('zakat')
                ->whereYear('created_at', now()->year)->select(['id', 'saved_by', 'created_at'])->first(),
        ]);
    }
}
