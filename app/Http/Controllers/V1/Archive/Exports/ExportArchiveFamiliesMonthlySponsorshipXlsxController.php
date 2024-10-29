<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Exports\FamiliesMonthlySponsorshipIndexExport;
use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class ExportArchiveFamiliesMonthlySponsorshipXlsxController extends Controller implements HasMiddleware
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
            new FamiliesMonthlySponsorshipIndexExport,
            __(
                'exports.archive.monthly_sponsorship_families',
                [
                    'date' => $archive->created_at->translatedFormat('F Y'),
                ]
            ).'.xlsx'
        );
    }
}
