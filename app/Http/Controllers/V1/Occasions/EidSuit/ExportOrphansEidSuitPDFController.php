<?php

namespace App\Http\Controllers\V1\Occasions\EidSuit;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportOrphansEidSuitPDFController extends Controller implements HasMiddleware
{
    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('occasions/eid-suit', 'sponsorships', function () {
            return listOfOrphansBenefitingFromTheEidSuitSponsorshipForExport();
        }, now()->year);
    }

    public static function middleware()
    {
        return ['can:export_occasions'];
    }
}
