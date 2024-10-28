<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportFamiliesRamadanBasketPDFController extends Controller
{
    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('occasions/ramadan-basket-families', 'sponsorships', function () {
            return listOfFamiliesBenefitingFromTheRamadanBasketSponsorshipForExport();
        }, now()->year);
    }

    public static function middleware()
    {
        return ['can:export_occasions'];
    }
}
