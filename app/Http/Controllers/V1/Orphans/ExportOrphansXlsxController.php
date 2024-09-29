<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Exports\orphansIndexExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportOrphansXlsxController extends Controller implements HasMiddleware
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(): BinaryFileResponse
    {
        return Excel::download(new OrphansIndexExport(), __('exports.orphans').'.xlsx');
    }

    public static function middleware()
    {
        return ['can:export_orphans'];
    }
}
