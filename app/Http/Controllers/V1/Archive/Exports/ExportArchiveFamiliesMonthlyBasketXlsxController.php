<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Exports\FamiliesMonthlyBasketIndexExport;
use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ExportArchiveFamiliesMonthlyBasketXlsxController extends Controller implements HasMiddleware
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(Archive $archive)
    {
        return Excel::download(
            new FamiliesMonthlyBasketIndexExport,
            __(
                'exports.archive.monthly_basket_families',
                [
                    'date' => $archive->created_at->translatedFormat('F Y'),
                ]
            ).'.xlsx'
        );
    }

    public static function middleware()
    {
        return ['can:export_archive'];
    }
}
