<?php

namespace App\Http\Controllers\V1\Occasions\EidSuit;

use App\Exports\OrphansEidSuitIndexExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportOrphansEidSuitXlsxController extends Controller implements HasMiddleware
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
            new OrphansEidSuitIndexExport,
            __(
                'exports.eid_suit',
                ['date' => now()->year]
            ).'.xlsx'
        );
    }
}
