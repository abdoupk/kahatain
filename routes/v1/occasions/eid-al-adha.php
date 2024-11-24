<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\EidAlAdha\EidAlAdhaIndexController;
use App\Http\Controllers\V1\Occasions\EidAlAdha\ExportFamiliesEidAlAdhaPDFController;
use App\Http\Controllers\V1\Occasions\EidAlAdha\ExportFamiliesEidAlAdhaXlsxController;
use App\Http\Controllers\V1\Occasions\EidAlAdha\SaveFamiliesEidAlAdhaToArchiveController;

Route::prefix('eid-al-adha')->name('eid-al-adha.')->group(function (): void {
    Route::get(
        '',
        EidAlAdhaIndexController::class
    )
        ->name('index');

    Route::get(
        'export-pdf',
        ExportFamiliesEidAlAdhaPDFController::class
    )
        ->name('export.pdf');

    Route::get(
        'export-xlsx',
        ExportFamiliesEidAlAdhaXlsxController::class
    )
        ->name('export.xlsx');

    Route::get(
        'save-to-archive',
        SaveFamiliesEidAlAdhaToArchiveController::class
    )->name('save-to-archive');
});
