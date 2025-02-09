<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportArchiveFamiliesMonthlyBasketPDFController extends Controller implements HasMiddleware
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
        return saveArchiveToPDF('monthly-basket-families', fn() => listOfFamiliesBenefitingFromTheMonthlyBasketForExport(), $archive->created_at->translatedFormat('F Y'));
    }
}
