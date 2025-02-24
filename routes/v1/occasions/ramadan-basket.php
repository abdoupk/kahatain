<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\RamadanBasket\ExportFamiliesRamadanBasketPDFController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\ExportFamiliesRamadanBasketXlsxController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\ExportRamadanBasketItemsPDFController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\GetRamadanBasketCategoriesController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\GetRamadanSponsorshipSettingsController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\ListItemsOfRamadanBasketController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\RamadanBasketIndexController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\SaveFamiliesRamadanBasketToArchiveController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\UpdateRamadanBasketItemsController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\UpdateRamadanSponsorshipSettingsController;

Route::prefix('ramadan-basket')
    ->name('ramadan-basket.')
    ->group(function (): void {
        Route::get(
            '',
            RamadanBasketIndexController::class
        )
            ->name('index');

        Route::get(
            'export-pdf',
            ExportFamiliesRamadanBasketPDFController::class
        )
            ->name('export.pdf');

        Route::get(
            'get-items',
            ListItemsOfRamadanBasketController::class
        )
            ->name('get-items');

        Route::get(
            'export-xlsx',
            ExportFamiliesRamadanBasketXlsxController::class
        )
            ->name('export.xlsx');

        Route::get(
            'save-to-archive',
            SaveFamiliesRamadanBasketToArchiveController::class
        )->name('save-to-archive');

        Route::get(
            'get-settings',
            GetRamadanSponsorshipSettingsController::class
        )->name('get-settings');

        Route::get(
            'get-categories',
            GetRamadanBasketCategoriesController::class
        )->name('get-categories');

        Route::patch(
            'update-settings',
            UpdateRamadanSponsorshipSettingsController::class
        )->name('update-settings');

        Route::patch(
            'update-ramadan-basket-items',
            UpdateRamadanBasketItemsController::class
        )->name('update-ramadan-basket-items');

        Route::get(
            'export-monthly-basket-items-pdf', ExportRamadanBasketItemsPDFController::class
        )
            ->name('export-monthly-basket-items.pdf');
    });
