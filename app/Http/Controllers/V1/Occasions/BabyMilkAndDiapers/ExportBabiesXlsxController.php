<?php

namespace App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers;

use App\Exports\BabiesIndexExport;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Routing\Controllers\HasMiddleware;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportBabiesXlsxController extends Controller implements HasMiddleware
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(): BinaryFileResponse
    {
        return Excel::download(new BabiesIndexExport(), __('exports.babies_milk_and_diapers', [
            'date' => now()->translatedFormat('F Y'),
        ]).'.xlsx');
    }

    public static function middleware()
    {
        return ['can:export_occasions'];
    }
}
