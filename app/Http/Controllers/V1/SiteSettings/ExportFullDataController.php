<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use App\Jobs\V1\SiteSettings\ExportDataJob;
use Storage;

class ExportFullDataController extends Controller
{
    public function __invoke()
    {
        $path = Storage::path('exported_data.zip');

        dispatch(new ExportDataJob($path, tenant('id')));

        return response('', 200);
    }
}
