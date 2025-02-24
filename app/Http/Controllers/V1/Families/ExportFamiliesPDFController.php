<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportFamiliesPDFController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_families'];
    }

    /**
     * @throws CouldNotTakeBrowsershot
     * @throws Throwable
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('families', 'families', fn () => getFamiliesForExport());
    }
}
