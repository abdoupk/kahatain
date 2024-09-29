<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Financial\ExportFinancialTransactionsPDFController;
use App\Http\Controllers\V1\Financial\ExportFinancialTransactionsXlsxController;
use App\Http\Controllers\V1\Financial\FinancialDeleteController;
use App\Http\Controllers\V1\Financial\FinancialDetailsController;
use App\Http\Controllers\V1\Financial\FinancialForceDeleteController;
use App\Http\Controllers\V1\Financial\FinancialIndexController;
use App\Http\Controllers\V1\Financial\FinancialRestoreController;
use App\Http\Controllers\V1\Financial\FinancialShowController;
use App\Http\Controllers\V1\Financial\FinancialStatisticsController;
use App\Http\Controllers\V1\Financial\FinancialStoreController;
use App\Http\Controllers\V1\Financial\FinancialUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('financial')->name('financial.')->group(function (): void {
    Route::get(
        '',
        FinancialIndexController::class
    )
        ->name('index');

    Route::get(
        'show/{finance}',
        FinancialShowController::class
    )
        ->name('show');

    Route::put(
        '{finance}',
        FinancialUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::post(
        '',
        FinancialStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{finance}',
        FinancialDeleteController::class
    )
        ->name('destroy');

    Route::get(
        'statistics',
        FinancialStatisticsController::class
    )
        ->name('statistics');

    Route::get(
        'export-pdf',
        ExportFinancialTransactionsPDFController::class
    )
        ->name('export.pdf');

    Route::get(
        'export-xlsx',
        ExportFinancialTransactionsXlsxController::class
    )
        ->name('export.xlsx');

    Route::get(
        'details/{finance}',
        FinancialDetailsController::class
    )
        ->name('details');

    Route::delete(
        '{finance}/force-delete',
        FinancialForceDeleteController::class
    )
        ->name('force-delete')->withTrashed();

    Route::post(
        '{finance}/restore',
        FinancialRestoreController::class
    )
        ->name('restore')
        ->withTrashed();
});
