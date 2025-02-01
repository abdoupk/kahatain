<?php

declare(strict_types=1);

use App\Http\Controllers\V1\MonthlySponsorships\ListItemsOfMonthlyBasketController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\ExportFamiliesMonthlyBasketPDFController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\ExportFamiliesMonthlyBasketXlsxController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\FamiliesMonthlyBasketIndexController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\SaveFamiliesMonthlyBasketToArchiveController;

Route::prefix('monthly-basket')
    ->name('monthly-basket.')
    ->group(function (): void {
        Route::get(
            '',
            FamiliesMonthlyBasketIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportFamiliesMonthlyBasketPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'export-xlsx',
            ExportFamiliesMonthlyBasketXlsxController::class
        )
            ->name('export.xlsx');

        Route::get(
            'save-to-archive',
            SaveFamiliesMonthlyBasketToArchiveController::class
        )->name('save-to-archive');

        Route::get(
            'list-items-of-monthly-basket',
            ListItemsOfMonthlyBasketController::class
        )->name('get-items');
    });
