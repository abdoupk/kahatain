<?php

namespace App\Http\Controllers\V1\Occasions\Zakat;

use App\Exports\FamiliesZakatIndexExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportFamiliesZakatXlsxController extends Controller implements HasMiddleware
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
            new FamiliesZakatIndexExport,
            __(
                'exports.zakat_families',
                ['date' => now()->translatedFormat('j'.__('glue').'F Y')]
            ).'.xlsx'
        );
    }
}
