<?php

namespace App\Http\Controllers\V1\Occasions\MonthlyBasket;

use App\Exports\FamiliesMonthlyBasketIndexExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;

class ExportFamiliesMonthlyBasketXlsxController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_occasions'];
    }

    public function __invoke()
    {
        return Excel::download(
            new FamiliesMonthlyBasketIndexExport,
            __(
                'exports.monthly_basket',
                ['date' => now()->translatedFormat('F Y')]
            ).'.xlsx'
        );
    }
}
