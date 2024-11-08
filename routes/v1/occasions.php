<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\BabyMilkAndDiapersIndexController;
use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\ExportBabiesPDFController;
use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\ExportBabiesXlsxController;
use App\Http\Controllers\V1\Occasions\BabyMilkAndDiapers\SaveBabiesToArchiveController;
use App\Http\Controllers\V1\Occasions\EidAlAdha\EidAlAdhaIndexController;
use App\Http\Controllers\V1\Occasions\EidAlAdha\ExportFamiliesEidAlAdhaPDFController;
use App\Http\Controllers\V1\Occasions\EidAlAdha\ExportFamiliesEidAlAdhaXlsxController;
use App\Http\Controllers\V1\Occasions\EidAlAdha\SaveFamiliesEidAlAdhaToArchiveController;
use App\Http\Controllers\V1\Occasions\EidSuit\EidSuitIndexController;
use App\Http\Controllers\V1\Occasions\EidSuit\ExportOrphansEidSuitPDFController;
use App\Http\Controllers\V1\Occasions\EidSuit\ExportOrphansEidSuitXlsxController;
use App\Http\Controllers\V1\Occasions\EidSuit\SaveOrphansEidSuitToArchiveController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\ExportFamiliesMonthlyBasketPDFController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\ExportFamiliesMonthlyBasketXlsxController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\FamiliesMonthlyBasketIndexController;
use App\Http\Controllers\V1\Occasions\MonthlyBasket\SaveFamiliesMonthlyBasketToArchiveController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\ExportFamiliesRamadanBasketPDFController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\ExportFamiliesRamadanBasketXlsxController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\GetRamadanSponsorshipSettingsController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\RamadanBasketIndexController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\SaveFamiliesRamadanBasketToArchiveController;
use App\Http\Controllers\V1\Occasions\RamadanBasket\UpdateRamadanSponsorshipSettingsController;
use App\Http\Controllers\V1\Occasions\SchoolEntry\ExportOrphansSchoolEntryPDFController;
use App\Http\Controllers\V1\Occasions\SchoolEntry\ExportOrphansSchoolEntryXlsxController;
use App\Http\Controllers\V1\Occasions\SchoolEntry\SaveOrphansSchoolEntryToArchiveController;
use App\Http\Controllers\V1\Occasions\SchoolEntry\SchoolEntryIndexController;

Route::prefix('projects')->name('occasions.')->group(function (): void {
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

            Route::patch(
                'update-settings',
                UpdateRamadanSponsorshipSettingsController::class
            )->name('update-settings');
        });

    Route::prefix('eid-suit')
        ->name('eid-suit.')
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
        });

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
        });

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
});
