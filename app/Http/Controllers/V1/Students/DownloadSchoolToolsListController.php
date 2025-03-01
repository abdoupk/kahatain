<?php

namespace App\Http\Controllers\V1\Students;

use App\Http\Controllers\Controller;
use App\Jobs\V1\School\DownloadSchoolToolsListJob;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Browsershot\Browsershot;

use function Spatie\LaravelPdf\Support\pdf;

class DownloadSchoolToolsListController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:export_school_supplies'];
    }

    public function __invoke()
    {
        dispatch(new DownloadSchoolToolsListJob(auth()->user()));

        return pdf()
            ->view('pdf.school-tools', [
                'data' => generateSchoolTools(),
            ])
            ->landscape()
            ->withBrowsershot(function (Browsershot $browsershot): void {
                $browsershot
                    ->margins(2, 4, 2, 4)
                    ->format('A3');

                if (! app()->environment('local')) {
                    $browsershot->setNodeBinary(config('app.browsershot.node_binary'));
                    $browsershot->setNpmBinary(config('app.browsershot.npm_binary'));
                }
            })
            ->name(__('school_supplies_list', ['date' => now()->format('Y')]))
            ->download();

    }
}
