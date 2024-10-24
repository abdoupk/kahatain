<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Exports\OrphansEidSuitIndexExport;
use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ExportArchiveOrphansEidSuitXlsxController extends Controller implements HasMiddleware
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(Archive $archive)
    {
        return Excel::download(
            new OrphansEidSuitIndexExport,
            __('exports.archive.eid_suit', ['date' => $archive->created_at->year]).'.xlsx'
        );
    }

    public static function middleware()
    {
        return ['can:export_archive'];
    }
}
