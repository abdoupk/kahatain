<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Exports\FamiliesRamadanBasketIndexExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportFamiliesRamadanBasketXlsxController extends Controller
{
    public static function middleware()
    {
        return ['can:export_occasions'];
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(): BinaryFileResponse
    {
        return Excel::download(
            new FamiliesRamadanBasketIndexExport,
            __(
                'exports.ramadan_basket_families',
                ['date' => now()->year]).'.xlsx'
        );
    }
}
