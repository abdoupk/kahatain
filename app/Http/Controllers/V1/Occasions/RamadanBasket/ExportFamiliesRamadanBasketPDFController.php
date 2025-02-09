<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportFamiliesRamadanBasketPDFController extends Controller
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
        return saveToPDF('occasions/ramadan-basket-families', 'families', fn() => listOfFamiliesBenefitingFromTheRamadanBasketSponsorshipForExport(), now()->year);
    }
}
