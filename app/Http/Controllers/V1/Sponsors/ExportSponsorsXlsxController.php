<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Exports\SponsorsIndexExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportSponsorsXlsxController extends Controller implements HasMiddleware
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(): BinaryFileResponse
    {
        return Excel::download(new SponsorsIndexExport, __('exports.sponsors').'.xlsx');
    }

    public static function middleware()
    {
        return ['can:export_sponsors'];
    }
}
