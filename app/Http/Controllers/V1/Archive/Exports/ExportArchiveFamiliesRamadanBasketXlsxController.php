<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Exports\FamiliesRamadanBasketIndexExport;
use App\Http\Controllers\Controller;
use App\Models\Archive;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ExportArchiveFamiliesRamadanBasketXlsxController extends Controller
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(Archive $archive)
    {
        return Excel::download(
            new FamiliesRamadanBasketIndexExport(),
            __('exports.archive.ramadan_basket_families', ['date' => $archive->created_at->year]).'.xlsx'
        );
    }

    public static function middleware()
    {
        return ['can:export_archive'];
    }
}
