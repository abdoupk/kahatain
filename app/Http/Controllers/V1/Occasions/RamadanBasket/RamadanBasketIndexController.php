<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\RamadanBasketResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class RamadanBasketIndexController extends Controller implements HasMiddleware
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/occasions/ramadan-basket/RamadanBasketIndex', [
            'families' => RamadanBasketResource::collection(listOfFamiliesBenefitingFromTheRamadanBasketSponsorship()),
            'params' => getParams(),
            'archive' => fn () => Archive::with('savedBy:id,first_name,last_name')->whereOccasion('ramadan_basket')
                ->whereYear('created_at', now()->year)->select(['id', 'saved_by', 'created_at'])->first(),
        ]);
    }

    public static function middleware()
    {
        return ['can:view_occasions'];
    }
}
