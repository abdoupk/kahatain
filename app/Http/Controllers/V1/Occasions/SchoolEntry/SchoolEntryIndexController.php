<?php

namespace App\Http\Controllers\V1\Occasions\SchoolEntry;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Occasions\SchoolEntryResource;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class SchoolEntryIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_occasions'];
    }

    public function __invoke()
    {
        return Inertia::render('Tenant/occasions/school-entry/SchoolEntryIndex', [
            'orphans' => SchoolEntryResource::collection(listOfOrphansBenefitingFromTheSchoolEntrySponsorship()),
            'params' => getParams(),
            'archive' => fn () => Archive::with('savedBy:id,first_name,last_name')->whereOccasion('school_entry')
                ->whereYear('created_at', now()->year)->select(['id', 'saved_by', 'created_at'])->first(),
        ]);
    }
}
