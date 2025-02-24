<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\BabyMilkAndDiapersIndexController;
use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\ExportBabiesPDFController;
use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\ExportBabiesXlsxController;
use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\SaveBabiesToArchiveController;

Route::prefix('babies-milk-and-diapers')
    ->name('babies-milk-and-diapers.')
    ->group(function (): void {
        Route::get(
            '',
            BabyMilkAndDiapersIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportBabiesPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'export-xlsx',
            ExportBabiesXlsxController::class
        )
            ->name('export.xlsx');

        Route::get(
            'save-to-archive',
            SaveBabiesToArchiveController::class
        )->name('save-to-archive');
    });
