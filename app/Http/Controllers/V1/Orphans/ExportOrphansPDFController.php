<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class ExportOrphansPDFController extends Controller implements HasMiddleware
{
    /**
     * @throws CouldNotTakeBrowsershot
     * @throws Throwable
     */
    public function __invoke(): StreamedResponse
    {
        return saveToPDF('orphans', 'orphans', function () {
            return getOrphansForExport();
        });
    }
    public static function middleware()
    {
        return ['can:export_orphans'];
    }
}
