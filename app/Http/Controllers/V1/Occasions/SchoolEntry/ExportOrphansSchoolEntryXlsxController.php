<?php

namespace App\Http\Controllers\V1\Occasions\SchoolEntry;

use App\Exports\OrphansSchoolEntryIndexExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportOrphansSchoolEntryXlsxController extends Controller implements HasMiddleware
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(): BinaryFileResponse
    {
        return Excel::download(
            new OrphansSchoolEntryIndexExport,
            __(
                'exports.school_entry',
                ['date' => now()->year]
            ).'.xlsx'
        );
    }

    public static function middleware()
    {
        return ['can:export_occasions'];
    }
}
