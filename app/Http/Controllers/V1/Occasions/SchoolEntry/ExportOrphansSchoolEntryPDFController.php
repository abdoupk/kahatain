<?php

namespace App\Http\Controllers\V1\Occasions\SchoolEntry;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportOrphansSchoolEntryPDFController extends Controller implements HasMiddleware
{
    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('occasions/school-entry', 'sponsorships', function () {
            return listOfOrphansBenefitingFromTheSchoolEntrySponsorshipForExport();
        }, now()->year);
    }

    public static function middleware()
    {
        return ['can:export_occasions'];
    }
}
