<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use Spatie\Browsershot\Browsershot;

use function Spatie\LaravelPdf\Support\pdf;

class DownloadSchoolToolsListController extends Controller
{
    public function __invoke()
    {
        return pdf()
            ->view('pdf.school-tools', [
                'data' => generateSchoolTools(),
            ])
            ->landscape()
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot
//                    ->setNodeBinary('/home/abdou/.nvm/versions/node/v22.9.0/bin/node')
//                    ->setNpmBinary('/home/abdou/.nvm/versions/node/v22.9.0/bin/npm')
                    ->margins(2, 4, 2, 4)
                    ->format('A3');
            })
            ->name('test-2023-04-10.pdf')
            ->download();
    }
}
