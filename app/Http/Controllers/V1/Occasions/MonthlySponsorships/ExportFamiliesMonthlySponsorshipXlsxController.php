<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Exports\FamiliesMonthlySponsorshipIndexExport;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Maatwebsite\Excel\Facades\Excel;

class ExportFamiliesMonthlySponsorshipXlsxController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_occasions'];
    }

    public function __invoke()
    {
        return Excel::download(
            new FamiliesMonthlySponsorshipIndexExport,
            __(
                'exports.monthly_sponsorship_families',
                ['date' => now()->translatedFormat('F Y')]
            ).'.xlsx'
        );
    }
}
