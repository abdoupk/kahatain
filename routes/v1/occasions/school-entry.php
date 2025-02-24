<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\SchoolEntry\ExportOrphansSchoolEntryPDFController;
use App\Http\Controllers\V1\Occasions\SchoolEntry\ExportOrphansSchoolEntryXlsxController;
use App\Http\Controllers\V1\Occasions\SchoolEntry\SaveOrphansSchoolEntryToArchiveController;
use App\Http\Controllers\V1\Occasions\SchoolEntry\SchoolEntryIndexController;

Route::prefix('school-entry')
    ->name('school-entry.')
    ->group(function (): void {
        Route::get(
            '',
            SchoolEntryIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportOrphansSchoolEntryPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'export-xlsx',
            ExportOrphansSchoolEntryXlsxController::class
        )
            ->name('export.xlsx');

        Route::get(
            'save-to-archive',
            SaveOrphansSchoolEntryToArchiveController::class
        )->name('save-to-archive');
    });
