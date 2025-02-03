<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Occasion\MonthlySponsorshipFamiliesListSavedJob;
use App\Models\Archive;
use App\Models\Family;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Throwable;

class SaveFamiliesMonthlySponsorshipToArchiveController extends Controller implements HasMiddleware
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
            ->whereOccasion('monthly_sponsorship')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->first() ?? Archive::create([
                'occasion' => 'monthly_sponsorship',
                'saved_by' => auth()->user()->id,
            ]);
    }

    private function restoreQuantities(Archive $archive): void
    {
        $families_count = $archive->listFamilies()->count();

        DB::update('
                UPDATE inventories
                SET qty = inventories.qty + (monthly_baskets.qty_for_family * ?)
                FROM monthly_baskets
                WHERE inventories.id = monthly_baskets.inventory_id
                AND monthly_baskets.status = true',
            [$families_count]);
    }

    private function syncFamiliesWithArchive(Archive $archive): void
    {
        $archive->families()
            ->syncWithPivotValues(
                listOfFamiliesBenefitingFromTheMonthlySponsorshipForExport()
                    ->map(function (Family $family) {
                        return $family->id;
                    }),
                ['tenant_id' => tenant('id')]
            );
    }

    private function decrementQuantities(Archive $archive): void
    {
        $families_count = $archive->listFamilies()->count();

        DB::update('
                UPDATE inventories
                SET qty = inventories.qty - (monthly_baskets.qty_for_family * ?)
                FROM monthly_baskets
                WHERE inventories.id = monthly_baskets.inventory_id
                AND monthly_baskets.status = true',
            [$families_count]);
    }

    private function dispatchJob(Archive $archive): void
    {
        dispatch(new MonthlySponsorshipFamiliesListSavedJob($archive, auth()->user()));
    }
}
