<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportArchiveFamiliesMonthlySponsorshipPDFController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_archive'];
    }

    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(Archive $archive): StreamedResponse
    {
        return saveArchiveToPDF('monthly-sponsorship-families', function () {
            return listOfFamiliesBenefitingFromTheMonthlySponsorshipForExport();
        }, $archive->created_at->translatedFormat('F Y'), 'families');
    }
}
