<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Families\ExportFamiliesPDFController;
use App\Http\Controllers\V1\Families\ExportFamiliesXlsxController;
use App\Http\Controllers\V1\Families\FamiliesIndexController;
use App\Http\Controllers\V1\Families\FamiliesPositionsController;
use App\Http\Controllers\V1\Families\FamiliesStatisticsController;
use App\Http\Controllers\V1\Families\FamilyCreateController;
use App\Http\Controllers\V1\Families\FamilyDeleteController;
use App\Http\Controllers\V1\Families\FamilyEditController;
use App\Http\Controllers\V1\Families\FamilyForceDeleteController;
use App\Http\Controllers\V1\Families\FamilyRestoreController;
use App\Http\Controllers\V1\Families\FamilyShowController;
use App\Http\Controllers\V1\Families\FamilyStoreController;
use App\Http\Controllers\V1\Families\FamilyUpdateFurnishingsController;
use App\Http\Controllers\V1\Families\FamilyUpdateHousingController;
use App\Http\Controllers\V1\Families\FamilyUpdateInfoController;
use App\Http\Controllers\V1\Families\FamilyUpdateReportController;
use App\Http\Controllers\V1\Families\FamilyUpdateSecondSponsorController;
use App\Http\Controllers\V1\Families\FamilyUpdateSponsorShipsController;
use App\Http\Controllers\V1\Families\FamilyUpdateSpouseController;
use App\Http\Controllers\V1\Families\SearchFamiliesController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('families')->name('families.')->group(function (): void {
    Route::get(
        '',
        FamiliesIndexController::class
    )
        ->name('index');

    Route::get(
        '/create',
        FamilyCreateController::class
    )
        ->name('create');

    Route::post(
        '',
        FamilyStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::get(
        'edit/{family}',
        FamilyEditController::class
    )
        ->name('edit');

    Route::get(
        'show/{family}',
        FamilyShowController::class
    )
        ->name('show');

    Route::put(
        '{family}',
        FamilyDeleteController::class
    )
        ->name('destroy');

    Route::get(
        'export-pdf',
        ExportFamiliesPDFController::class
    )
        ->name('export.pdf');

    Route::get(
        'export-xlsx',
        ExportFamiliesXlsxController::class
    )
        ->name('export.xlsx');

    Route::get(
        'search',
        SearchFamiliesController::class
    )
        ->name('search');

    Route::put(
        'infos/{family}',
        FamilyUpdateInfoController::class
    )
        ->name('infos-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'spouse/{family}',
        FamilyUpdateSpouseController::class
    )
        ->name('spouse-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'report/{family}',
        FamilyUpdateReportController::class
    )
        ->name('report-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'second-sponsor/{family}',
        FamilyUpdateSecondSponsorController::class
    )
        ->name('second-sponsor-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'housing/{family}',
        FamilyUpdateHousingController::class
    )
        ->name('housing-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'furnishings/{family}',
        FamilyUpdateFurnishingsController::class
    )
        ->name('furnishings-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'sponsorships/{family}',
        FamilyUpdateSponsorShipsController::class
    )
        ->name('sponsorships-update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::post(
        '{family}/restore',
        FamilyRestoreController::class
    )
        ->name('restore')
        ->withTrashed();

    Route::delete(
        '{family}/force-delete',
        FamilyForceDeleteController::class
    )
        ->name('force-delete')
        ->withTrashed();

    Route::get(
        'statistics',
        FamiliesStatisticsController::class
    )
        ->name('statistics');

    Route::get(
        'positions',
        FamiliesPositionsController::class
    )
        ->name('positions');
});
