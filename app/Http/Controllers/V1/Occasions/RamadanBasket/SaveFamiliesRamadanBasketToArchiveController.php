<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Occasion\RamadanBasketFamiliesListSavedJob;
use App\Models\Archive;
use App\Models\Family;

class SaveFamiliesRamadanBasketToArchiveController extends Controller
{
    public static function middleware()
    {
        return ['can:save_occasions'];
    }

    public function __invoke(): void
    {
        $archive = Archive::where('occasion', '=', 'ramadan_basket')
            ->whereYear('created_at', '=', now()->year)->firstOrCreate([
                'occasion' => 'ramadan_basket',
                'saved_by' => auth()->user()->id,
            ]);

        $archive->families()
            ->syncWithPivotValues(
                listOfFamiliesBenefitingFromTheRamadanBasketSponsorshipForExport()
                    ->map(function (Family $family) {
                        return $family->id;
                    }),
                ['tenant_id' => tenant('id')]
            );

        dispatch(new RamadanBasketFamiliesListSavedJob($archive, auth()->user()));
    }
}
