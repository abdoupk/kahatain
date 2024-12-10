<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\MeatDistribution\ExportFamiliesMeatDistributionPDFController;
use App\Http\Controllers\V1\Occasions\MeatDistribution\ExportFamiliesMeatDistributionXlsxController;
use App\Http\Controllers\V1\Occasions\MeatDistribution\FamiliesMeatDistributionIndexController;
use App\Http\Controllers\V1\Occasions\MeatDistribution\SaveFamiliesMeatDistributionToArchiveController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('meat-distribution')
    ->name('meat-distribution.')
    ->group(function (): void {
        Route::get(
            '',
            FamiliesMeatDistributionIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportFamiliesMeatDistributionPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'export-xlsx',
            ExportFamiliesMeatDistributionXlsxController::class
        )
            ->name('export.xlsx');

        Route::post(
            'save-to-archive',
            SaveFamiliesMeatDistributionToArchiveController::class
        )->name('save-to-archive')
            ->middleware([HandlePrecognitiveRequests::class]);
    });
