<?php

namespace App\Http\Controllers\V1\Occasions\SchoolEntry;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Occasion\SchoolEntryOrphansListSavedJob;
use App\Models\Archive;
use App\Models\OrphanSponsorship;
use Illuminate\Routing\Controllers\HasMiddleware;

class SaveOrphansSchoolEntryToArchiveController extends Controller implements HasMiddleware
{
    public function __invoke(): void
    {
        $archive = Archive::where('occasion', '=', 'school_entry')
            ->whereYear('created_at', '=', now()->year)->firstOrCreate([
                'occasion' => 'school_entry',
                'saved_by' => auth()->user()->id,
            ]);

        $archive->orphans()
            ->syncWithPivotValues(
                listOfOrphansBenefitingFromTheSchoolEntrySponsorshipForExport()
                    ->map(function (OrphanSponsorship $sponsorship) {
                        return $sponsorship->orphan->id;
                    }),
                ['tenant_id' => tenant('id')]
            );

        dispatch(new SchoolEntryOrphansListSavedJob($archive, auth()->user()));
    }
    public static function middleware()
    {
        return ['can:save_occasions'];
    }
}
