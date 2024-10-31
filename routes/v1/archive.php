<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Archive\ArchiveDetailsBabiesMilkAndDiapersController;
use App\Http\Controllers\V1\Archive\ArchiveDetailsEidAlAdhaController;
use App\Http\Controllers\V1\Archive\ArchiveDetailsEidSuitController;
use App\Http\Controllers\V1\Archive\ArchiveDetailsMonthlyBasketController;
use App\Http\Controllers\V1\Archive\ArchiveDetailsMonthlySponsorshipController;
use App\Http\Controllers\V1\Archive\ArchiveDetailsRamadanBasketController;
use App\Http\Controllers\V1\Archive\ArchiveDetailsSchoolEntryController;
use App\Http\Controllers\V1\Archive\ArchiveIndexController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveBabiesMilkAndDiapersPDFController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveBabiesMilkAndDiapersXlsxController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesEidAlAdhaPDFController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesEidAlAdhaXlsxController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesMonthlyBasketPDFController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesMonthlyBasketXlsxController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesMonthlySponsorshipPDFController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesMonthlySponsorshipXlsxController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesRamadanBasketPDFController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveFamiliesRamadanBasketXlsxController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveOrphansEidSuitPDFController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveOrphansEidSuitXlsxController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveOrphansSchoolEntryPDFController;
use App\Http\Controllers\V1\Archive\Exports\ExportArchiveOrphansSchoolEntryXlsxController;

Route::prefix('archive')->name('archive.')->group(function (): void {
    Route::get(
        '',
        ArchiveIndexController::class
    )->name('index');

    Route::prefix('details')
        ->name('details.')
        ->group(function (): void {
            Route::get(
                'eid-al-adha/{archive}',
                ArchiveDetailsEidAlAdhaController::class
            )->name('eid-al-adha');

            Route::get(
                'monthly-basket/{archive}',
                ArchiveDetailsMonthlyBasketController::class
            )->name('monthly-basket');

            Route::get(
                'monthly-sponsorship/{archive}',
                ArchiveDetailsMonthlySponsorshipController::class
            )->name('monthly-sponsorship');

            Route::get(
                'ramadan-basket/{archive}',
                ArchiveDetailsRamadanBasketController::class
            )->name('ramadan-basket');

            Route::get(
                'school-entry/{archive}',
                ArchiveDetailsSchoolEntryController::class
            )->name('school-entry');

            Route::get(
                'eid-suit/{archive}',
                ArchiveDetailsEidSuitController::class
            )->name('eid-suit');

            Route::get(
                'babies-milk-and-diapers/{archive}',
                ArchiveDetailsBabiesMilkAndDiapersController::class
            )->name('babies-milk-and-diapers');
        });

    Route::prefix('export')->name('export.')->group(function (): void {
        Route::get(
            'eid-al-adha/export-pdf/{archive}',
            ExportArchiveFamiliesEidAlAdhaPDFController::class
        )->name('eid-al-adha.pdf');

        Route::get(
            'eid-al-adha/export-xlsx/{archive}',
            ExportArchiveFamiliesEidAlAdhaXlsxController::class
        )->name('eid-al-adha.xlsx');

        Route::get(
            'monthly-basket/export-pdf/{archive}',
            ExportArchiveFamiliesMonthlyBasketPDFController::class
        )->name('monthly-basket.pdf');

        Route::get(
            'monthly-basket/export-xlsx/{archive}',
            ExportArchiveFamiliesMonthlyBasketXlsxController::class
        )->name('monthly-basket.xlsx');

        Route::get(
            'ramadan-basket/export-pdf/{archive}',
            ExportArchiveFamiliesRamadanBasketPDFController::class
        )->name('ramadan-basket.pdf');

        Route::get(
            'ramadan-basket/export-xlsx/{archive}',
            ExportArchiveFamiliesRamadanBasketXlsxController::class
        )->name('ramadan-basket.xlsx');

        Route::get(
            'eid-suit/export-pdf/{archive}',
            ExportArchiveOrphansEidSuitPDFController::class
        )->name('eid-suit.pdf');

        Route::get(
            'eid-suit/export-xlsx/{archive}',
            ExportArchiveOrphansEidSuitXlsxController::class
        )->name('eid-suit.xlsx');

        Route::get(
            'school-entry/export-pdf/{archive}',
            ExportArchiveOrphansSchoolEntryPDFController::class
        )->name('school-entry.pdf');

        Route::get(
            'school-entry/export-xlsx/{archive}',
            ExportArchiveOrphansSchoolEntryXlsxController::class
        )->name('school-entry.xlsx');

        Route::get(
            'babies-milk-and-diapers/export-pdf/{archive}',
            ExportArchiveBabiesMilkAndDiapersPDFController::class
        )->name('babies-milk-and-diapers.pdf');

        Route::get(
            'babies-milk-and-diapers/export-xlsx/{archive}',
            ExportArchiveBabiesMilkAndDiapersXlsxController::class
        )->name('babies-milk-and-diapers.xlsx');

        Route::get(
            'monthly-sponsorship/export-pdf/{archive}',
            ExportArchiveFamiliesMonthlySponsorshipPDFController::class
        )->name('monthly-sponsorship.pdf');

        Route::get(
            'monthly-sponsorship/export-xlsx/{archive}',
            ExportArchiveFamiliesMonthlySponsorshipXlsxController::class
        )->name('monthly-sponsorship.xlsx');
    });
});
