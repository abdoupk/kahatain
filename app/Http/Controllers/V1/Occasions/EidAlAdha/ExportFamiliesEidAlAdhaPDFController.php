<?php

namespace App\Http\Controllers\V1\Occasions\EidAlAdha;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportFamiliesEidAlAdhaPDFController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_occasions'];
    }

    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('occasions/eid-al-adha-families', 'families', fn() => listOfFamiliesBenefitingFromTheEidAlAdhaSponsorshipForExport(), now()->year);
    }
}
