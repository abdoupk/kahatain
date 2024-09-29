<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportArchiveFamiliesRamadanBasketPDFController extends Controller implements HasMiddleware
{
    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(Archive $archive): StreamedResponse
    {
        return saveArchiveToPDF('ramadan-basket-families', function () {
            return listOfFamiliesBenefitingFromTheRamadanBasketSponsorshipForExport();
        }, $archive->created_at->year);
    }

    public static function middleware()
    {
        return ['can:export_archive'];
    }
}
