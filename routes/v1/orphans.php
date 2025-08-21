<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Orphans\ExportOrphansPDFController;
use App\Http\Controllers\V1\Orphans\ExportOrphansXlsxController;
use App\Http\Controllers\V1\Orphans\OrphanDeleteController;
use App\Http\Controllers\V1\Orphans\OrphanEditController;
use App\Http\Controllers\V1\Orphans\OrphanForceDeleteController;
use App\Http\Controllers\V1\Orphans\OrphanRestoreController;
use App\Http\Controllers\V1\Orphans\OrphanShowController;
use App\Http\Controllers\V1\Orphans\OrphansIndexController;
use App\Http\Controllers\V1\Orphans\OrphansStatisticsController;
use App\Http\Controllers\V1\Orphans\OrphanStoreController;
use App\Http\Controllers\V1\Orphans\OrphanUpdateInfosController;
use App\Http\Controllers\V1\Orphans\OrphanUpdateSponsorshipsController;
use App\Http\Controllers\V1\Orphans\SearchOrphansController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('orphans')->name('orphans.')->group(function (): void {
    Route::get(
        '',
        OrphansIndexController::class
    )
        ->name('index');

    Route::get(
        'show/{orphan}',
        OrphanShowController::class
    )
        ->name('show');

    Route::put(
        'infos/{orphan}',
        OrphanUpdateInfosController::class
    )
        ->name('infos-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'sponsorships/{orphan}',
        OrphanUpdateSponsorshipsController::class
    )
        ->name('sponsorships-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::get(
        'edit/{orphan}',
        OrphanEditController::class
    )
        ->name('edit');

    Route::delete(
        '{orphan}',
        OrphanDeleteController::class
    )
        ->name('destroy');

    Route::get(
        'export-pdf',
        ExportOrphansPDFController::class
    )
        ->name('export.pdf');

    Route::get(
        'export-xlsx',
        ExportOrphansXlsxController::class
    )
        ->name('export.xlsx');

    Route::get(
        'search',
        SearchOrphansController::class
    )
        ->name('search');

    Route::post(
        '{orphan}/restore',
        OrphanRestoreController::class
    )
        ->name('restore')
        ->withTrashed();

    Route::delete(
        '{orphan}/force-delete',
        OrphanForceDeleteController::class
    )
        ->name('force-delete')
        ->withTrashed();

    Route::get(
        'statistics',
        OrphansStatisticsController::class
    )
        ->name('statistics');

    Route::post('', OrphanStoreController::class)->name('store');
});
