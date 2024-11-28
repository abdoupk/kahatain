<?php

namespace App\Http\Controllers\V1\Archive\Exports;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportArchiveFamiliesZakatPDFController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_archive'];
    }

    /**
     * @throws Throwable
     * @throws CouldNotTakeBrowsershot
     */
    public function __invoke(Archive $archive): StreamedResponse
    {
        // TODO fix the attribute display issue corrupted file name
        return saveArchiveToPDF('zakat-families', function () {
            return listOfFamiliesBenefitingFromTheZakatForExport();
        }, $archive->created_at->translatedFormat('j'.__('glue').'F Y'), attribute: formatCurrency($archive->metadata['amount']));
    }
}
