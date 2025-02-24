<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Exports\FamiliesZakatIndexExport;
use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ExportArchiveFamiliesZakatXlsxController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_archive'];
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(Archive $archive)
    {
        return Excel::download(
            new FamiliesZakatIndexExport,
            __('exports.archive.zakat_families', ['date' => $archive->created_at->translatedFormat('j'.__('glue').'F Y'),
                'attribute' => formatCurrency($archive->metadata['amount'])]).'.xlsx'
        );
    }
}
