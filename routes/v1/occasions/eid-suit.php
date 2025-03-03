<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\EidSuit\BulkUpdateEidSuitInfosController;
use App\Http\Controllers\V1\Occasions\EidSuit\EidSuitIndexController;
use App\Http\Controllers\V1\Occasions\EidSuit\ExportOrphansEidSuitPDFController;
use App\Http\Controllers\V1\Occasions\EidSuit\ExportOrphansEidSuitXlsxController;
use App\Http\Controllers\V1\Occasions\EidSuit\OrphanEidSuitInfosDetailsController;
use App\Http\Controllers\V1\Occasions\EidSuit\ResetEidSuitInfosController;
use App\Http\Controllers\V1\Occasions\EidSuit\SaveOrphanEidSuitInfosController;
use App\Http\Controllers\V1\Occasions\EidSuit\SaveOrphansEidSuitToArchiveController;

Route::prefix('eid-suit')->name('eid-suit.')
    ->group(function (): void {
        Route::get(
            '',
            EidSuitIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportOrphansEidSuitPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'export-xlsx',
            ExportOrphansEidSuitXlsxController::class
        )
            ->name('export.xlsx');

        Route::get(
            'save-to-archive',
            SaveOrphansEidSuitToArchiveController::class
        )->name('save-to-archive');

        Route::patch(
            'save-infos/{orphan}',
            SaveOrphanEidSuitInfosController::class)
            ->name('save-infos');

        Route::patch(
            'reset',
            ResetEidSuitInfosController::class)
            ->name('reset');

        Route::patch(
            'bulk-update',
            BulkUpdateEidSuitInfosController::class)
            ->name('bulk-update');

        Route::get(
            'show/{orphan}',
            OrphanEidSuitInfosDetailsController::class)
            ->name('show');
    });
