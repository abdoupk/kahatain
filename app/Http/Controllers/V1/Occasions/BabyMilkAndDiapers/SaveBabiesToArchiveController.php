<?php

namespace App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Occasion\BabiesMilkAndDiapersListSavedJob;
use App\Models\Archive;
use App\Models\Baby;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Throwable;

class SaveBabiesToArchiveController extends Controller implements HasMiddleware
{
    /**
     * @throws Throwable
     */
    public function __invoke(): void
    {
        DB::transaction(function (): void {
            $archive = $this->getOrCreateArchive();

            $this->restoreQuantities($archive);

            $this->syncBabiesWithArchive($archive);

            $this->decrementQuantities($archive);

            $this->dispatchJob($archive);
        });
    }
    public static function middleware()
    {
        return ['can:save_occasions'];
    }

    private function getOrCreateArchive()
    {
        return Archive::query()
            ->whereOccasion('babies_milk_and_diapers')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->first() ?? Archive::create([
                'occasion' => 'babies_milk_and_diapers',
                'saved_by' => auth()->user()->id,
            ]);
    }

    private function restoreQuantities(Archive $archive): void
    {
        $archive->listBabies()
            ->with(['diapers', 'babyMilk'])
            ->each(function (Baby $baby): void {
                $baby->diapers()->update(['qty' => $baby->diapers->qty + $baby->diapers_quantity]);

                $baby->babyMilk()->update(['qty' => $baby->babyMilk->qty + $baby->baby_milk_quantity]);
            });
    }

    private function syncBabiesWithArchive(Archive $archive): void
    {
        $archive->babies()
            ->syncWithPivotValues(
                getBabiesForExport()->pluck('id'),
                ['tenant_id' => tenant('id')]
            );
    }

    private function decrementQuantities(Archive $archive): void
    {
        $archive->listBabies()
            ->with(['diapers', 'babyMilk'])
            ->each(function (Baby $baby): void {
                $baby->diapers()->update(['qty' => $baby->diapers->qty - $baby->diapers_quantity]);

                $baby->babyMilk()->update(['qty' => $baby->babyMilk->qty - $baby->baby_milk_quantity]);
            });
    }

    private function dispatchJob(Archive $archive): void
    {
        dispatch(new BabiesMilkAndDiapersListSavedJob($archive, auth()->user()));
    }
}
