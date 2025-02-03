<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\MonthlySponsorships\ExportFamiliesMonthlySponsorshipPDFController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\ExportFamiliesMonthlySponsorshipXlsxController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\ExportMonthlyBasketItemsPDFController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\FamiliesMonthlySponsorshipIndexController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\GetMonthlySponsorshipSettingsController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\ListItemsOfMonthlyBasketController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\SaveFamiliesMonthlySponsorshipToArchiveController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\UpdateMonthlyBasketItemsController;
use App\Http\Controllers\V1\Occasions\MonthlySponsorships\UpdateMonthlySponsorshipSettingsController;

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
            'export-monthly-basket-items-pdf',
            ExportMonthlyBasketItemsPDFController::class
        )
            ->name('export-monthly-basket-items.pdf');

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

        Route::patch(
            'update-monthly-basket',
            UpdateMonthlyBasketItemsController::class
        )->name('update-monthly-basket');

        Route::get(
            'get-settings',
            GetMonthlySponsorshipSettingsController::class
        )->name('get-settings');

        Route::get(
            'list-items-of-monthly-basket',
            ListItemsOfMonthlyBasketController::class
        )->name('get-items');
    });
