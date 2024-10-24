<?php

use App\Http\Controllers\V1\MonthlySponsorships\ExportFamiliesMonthlySponsorshipPDFController;
use App\Http\Controllers\V1\MonthlySponsorships\ExportFamiliesMonthlySponsorshipXlsxController;
use App\Http\Controllers\V1\MonthlySponsorships\FamiliesMonthlySponsorshipIndexController;
use App\Http\Controllers\V1\MonthlySponsorships\GetMonthlySponsorshipSettingsController;
use App\Http\Controllers\V1\MonthlySponsorships\MonthlySponsorshipStoreController;
use App\Http\Controllers\V1\MonthlySponsorships\SaveFamiliesMonthlySponsorshipToArchiveController;
use App\Http\Controllers\V1\MonthlySponsorships\StoreMonthlySponsorshipController;
use App\Http\Controllers\V1\MonthlySponsorships\UpdateMonthlySponsorshipSettingsController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('monthly-sponsorship')
    ->name('monthly-sponsorship.')
    ->group(function (): void {
        Route::get(
            '',
            FamiliesMonthlySponsorshipIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportFamiliesMonthlySponsorshipPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'export-xlsx',
            ExportFamiliesMonthlySponsorshipXlsxController::class
        )
            ->name('export.xlsx');

        Route::get(
            'save-to-archive',
            SaveFamiliesMonthlySponsorshipToArchiveController::class
        )->name('save-to-archive');

        Route::patch(
            'update-settings',
            UpdateMonthlySponsorshipSettingsController::class
        )->name('update-settings');

        Route::post(
            '',
            MonthlySponsorshipStoreController::class
        )->name('store')
            ->middleware([HandlePrecognitiveRequests::class]);

        Route::get(
            'get-settings',
            GetMonthlySponsorshipSettingsController::class
        )->name('get-settings');
    });
