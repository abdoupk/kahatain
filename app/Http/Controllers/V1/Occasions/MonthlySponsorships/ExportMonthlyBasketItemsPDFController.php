<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Models\MonthlyBasket;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Throwable;

class ExportMonthlyBasketItemsPDFController extends Controller
{
    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke()
    {
        return saveToPDF('monthly-basket', 'monthly_basket',
            fn () => MonthlyBasket::with('inventory:id,name,unit,qty')->where('status', true)->get(), date: now()->translatedFormat('F Y'), landscape: false);
    }
}
