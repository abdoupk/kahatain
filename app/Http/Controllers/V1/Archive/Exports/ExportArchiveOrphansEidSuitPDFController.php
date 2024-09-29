<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportArchiveOrphansEidSuitPDFController extends Controller
{
    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(Archive $archive): StreamedResponse
    {
        return saveArchiveToPDF('eid-suit', function () {
            return listOfOrphansBenefitingFromTheEidSuitSponsorshipForExport();
        }, $archive->created_at->year);
    }

    public static function middleware()
    {
        return ['can:export_archive'];
    }
}
