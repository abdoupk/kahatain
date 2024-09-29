<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use Storage;

class DownloadExportedDataController extends Controller
{
    public function __invoke()
    {
        return Storage::download('exported_data.zip', now()->format('Y-m-d').'-'.__('exported_data').'.zip');
    }
}
