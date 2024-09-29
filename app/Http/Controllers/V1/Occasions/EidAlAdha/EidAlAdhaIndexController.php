<?php

namespace App\Http\Controllers\V1\Occasions\EidAlAdha;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\EidAlAdhaResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class EidAlAdhaIndexController extends Controller implements HasMiddleware
{
    public function __invoke()
    {
        return Inertia::render('Tenant/occasions/eid-al-adha/EidAlAdhaIndex', [
            'families' => EidAlAdhaResource::collection(listOfFamiliesBenefitingFromTheEidAlAdhaSponsorship()),
            'params' => getParams(),
            'archive' => fn () => Archive::with('savedBy:id,first_name,last_name')->whereOccasion('eid_al_adha')
                ->whereYear('created_at', now()->year)->select(['id', 'saved_by', 'created_at'])->first(),
        ]);
    }

    public static function middleware()
    {
        return ['can:view_occasions'];
    }
}
