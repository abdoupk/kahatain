<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use App\Models\RamadanBasket;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Throwable;

class ExportRamadanBasketItemsPDFController extends Controller
{
    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke()
    {
        return saveToPDF('ramadan-basket', 'ramadan_basket',
            fn () => RamadanBasket::with('inventory:id,name,unit,qty')->where('status', true)->get(), date: now()->year, landscape: false);
    }
}
