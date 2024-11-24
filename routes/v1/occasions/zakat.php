<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\Zakat\ExportFamiliesZakatPDFController;
use App\Http\Controllers\V1\Occasions\Zakat\ExportFamiliesZakatXlsxController;
use App\Http\Controllers\V1\Occasions\Zakat\FamiliesZakatIndexController;
use App\Http\Controllers\V1\Occasions\Zakat\SaveFamiliesZakatToArchiveController;
use App\Http\Controllers\V1\Occasions\Zakat\ZakatStoreController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('zakat')
    ->name('zakat.')
    ->group(function (): void {
        Route::get(
            '',
            FamiliesZakatIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportFamiliesZakatPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'export-xlsx',
            ExportFamiliesZakatXlsxController::class
        )
            ->name('export.xlsx');

        Route::post(
            'save-to-archive',
            SaveFamiliesZakatToArchiveController::class
        )->name('save-to-archive');

        Route::post(
            '',
            ZakatStoreController::class
        )->name('store')
            ->middleware([HandlePrecognitiveRequests::class]);
    });
