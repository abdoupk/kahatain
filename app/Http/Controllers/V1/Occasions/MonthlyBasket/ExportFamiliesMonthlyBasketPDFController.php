<?php

namespace App\Http\Controllers\V1\Occasions\MonthlyBasket;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportFamiliesMonthlyBasketPDFController extends Controller implements HasMiddleware
{
    /**
     * @throws \Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('occasions/monthly-basket-families', 'sponsorships', function () {
            return listOfFamiliesBenefitingFromTheMonthlyBasketForExport();
        }, now()->translatedFormat('F Y'));
    }

    public static function middleware()
    {
        return ['can:export_occasions'];
    }
}
