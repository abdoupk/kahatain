<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Occasion\RamadanBasketFamiliesListSavedJob;
use App\Models\Archive;
use App\Models\Family;
use DB;
use Throwable;

class SaveFamiliesRamadanBasketToArchiveController extends Controller
{
    public static function middleware()
    {
        return ['can:save_occasions'];
    }

    /**
     * @throws Throwable
     */
    public function __invoke(): void
    {
        DB::transaction(function (): void {
            $archive = $this->getOrCreateArchive();

            $this->restoreQuantities($archive);

            $this->syncFamiliesWithArchive($archive);

            $this->decrementQuantities($archive);

            $this->dispatchJob($archive);
        });
    }

    private function getOrCreateArchive()
    {
        return Archive::query()
            ->whereOccasion('ramadan_basket')
            ->whereYear('created_at', '=', now()->year)->firstOrCreate([
                'occasion' => 'ramadan_basket',
                'saved_by' => auth()->user()->id,
            ])->first() ?? Archive::create([
                'occasion' => 'monthly_sponsorship',
                'saved_by' => auth()->user()->id,
            ]);
    }

    private function restoreQuantities(Archive $archive): void
    {
        $families_count = $archive->listFamilies()->count();

        DB::update('
                UPDATE inventories
                SET qty = inventories.qty + (ramadan_baskets.qty_for_family * ?)
                FROM ramadan_baskets
                WHERE inventories.id = ramadan_baskets.inventory_id
                AND ramadan_baskets.status = true',
            [$families_count]);
    }

    private function syncFamiliesWithArchive(Archive $archive): void
    {
        $archive->families()
            ->syncWithPivotValues(
                listOfFamiliesBenefitingFromTheRamadanBasketSponsorshipForExport()
                    ->map(fn (Family $family) => $family->id),
                ['tenant_id' => tenant('id')]
            );
    }

    private function decrementQuantities(Archive $archive): void
    {
        $families_count = $archive->listFamilies()->count();

        DB::update('
                UPDATE inventories
                SET qty = inventories.qty - (ramadan_baskets.qty_for_family * ?)
                FROM ramadan_baskets
                WHERE inventories.id = ramadan_baskets.inventory_id
                AND ramadan_baskets.status = true',
            [$families_count]);
    }

    private function dispatchJob(Archive $archive): void
    {
        dispatch(new RamadanBasketFamiliesListSavedJob($archive, auth()->user()));
    }
}
