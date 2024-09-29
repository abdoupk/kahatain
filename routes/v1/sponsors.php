<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Sponsors\ExportSponsorsPDFController;
use App\Http\Controllers\V1\Sponsors\ExportSponsorsXlsxController;
use App\Http\Controllers\V1\Sponsors\SearchSponsorsController;
use App\Http\Controllers\V1\Sponsors\SponsorDeleteController;
use App\Http\Controllers\V1\Sponsors\SponsorEditController;
use App\Http\Controllers\V1\Sponsors\SponsorForceDeleteController;
use App\Http\Controllers\V1\Sponsors\SponsorRestoreController;
use App\Http\Controllers\V1\Sponsors\SponsorShowController;
use App\Http\Controllers\V1\Sponsors\SponsorsIndexController;
use App\Http\Controllers\V1\Sponsors\SponsorsStatisticsController;
use App\Http\Controllers\V1\Sponsors\SponsorUpdateIncomesController;
use App\Http\Controllers\V1\Sponsors\SponsorUpdateInfosController;
use App\Http\Controllers\V1\Sponsors\SponsorUpdateSponsorshipsController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('sponsors')->name('sponsors.')->group(function (): void {
    Route::get(
        '',
        SponsorsIndexController::class
    )
        ->name('index');

    Route::get(
        'show/{sponsor}',
        SponsorShowController::class
    )
        ->name('show');

    Route::put(
        'infos/{sponsor}',
        SponsorUpdateInfosController::class
    )
        ->name('infos-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'incomes/{sponsor}',
        SponsorUpdateIncomesController::class
    )
        ->name('incomes-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'sponsorships/{sponsor}',
        SponsorUpdateSponsorshipsController::class
    )
        ->name('sponsorships-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::get(
        'edit/{sponsor}',
        SponsorEditController::class
    )
        ->name('edit');

    Route::delete(
        '{sponsor}',
        SponsorDeleteController::class
    )
        ->name('destroy');

    Route::get(
        'export-pdf',
        ExportSponsorsPDFController::class
    )
        ->name('export.pdf');

    Route::get(
        'export-xlsx',
        ExportSponsorsXlsxController::class
    )
        ->name('export.xlsx');

    Route::get(
        'search',
        SearchSponsorsController::class
    )
        ->name('search');

    Route::post(
        '{sponsor}/restore',
        SponsorRestoreController::class
    )
        ->name('restore')
        ->withTrashed();

    Route::delete(
        '{sponsor}/force-delete',
        SponsorForceDeleteController::class
    )
        ->name('force-delete')
        ->withTrashed();

    Route::get(
        'statistics',
        SponsorsStatisticsController::class
    )
        ->name('statistics');
});
