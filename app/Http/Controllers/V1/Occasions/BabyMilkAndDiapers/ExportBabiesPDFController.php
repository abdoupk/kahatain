<?php

namespace App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportBabiesPDFController extends Controller implements HasMiddleware
{
    /**
     * @throws CouldNotTakeBrowsershot
     * @throws \Throwable
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('occasions/babies-milk-and-diapers', 'babies', function () {
            return getBabiesForExport();
        }, now()->translatedFormat('F Y'));
    }
    public static function middleware()
    {
        return ['can:export_occasions'];
    }
}
