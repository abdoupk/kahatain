<?php

declare(strict_types=1);

use App\Http\Controllers\V1\PrivateSchools\ExportSchoolDetailsPDFController;
use App\Http\Controllers\V1\PrivateSchools\SchoolDeleteController;
use App\Http\Controllers\V1\PrivateSchools\SchoolDetailsController;
use App\Http\Controllers\V1\PrivateSchools\SchoolForceDeleteController;
use App\Http\Controllers\V1\PrivateSchools\SchoolRestoreController;
use App\Http\Controllers\V1\PrivateSchools\SchoolShowController;
use App\Http\Controllers\V1\PrivateSchools\SchoolsIndexController;
use App\Http\Controllers\V1\PrivateSchools\SchoolStoreController;
use App\Http\Controllers\V1\PrivateSchools\SchoolUpdateController;
use App\Http\Controllers\V1\Schools\SchoolsSearchController;
use App\Http\Controllers\V1\Universities\UniversitiesSearchController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('schools')->name('schools.')->group(callback: function (): void {
    Route::get(
        '',
        SchoolsIndexController::class
    )
        ->name('index');

    Route::post(
        '',
        SchoolStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        '{school}',
        SchoolUpdateController::class
    )
        ->name('update');

    Route::get(
        'show/{school}',
        SchoolShowController::class
    )
        ->name('show');

    Route::get(
        'details/{school}',
        SchoolDetailsController::class
    )
        ->name('details');

    Route::delete(
        '{school}',
        SchoolDeleteController::class
    )
        ->name('destroy');

    Route::post(
        '{school}/restore',
        SchoolRestoreController::class
    )
        ->name('restore')
        ->withTrashed();

    Route::delete(
        '{school}/force-delete',
        SchoolForceDeleteController::class
    )
        ->name('force-delete')
        ->withTrashed();

    Route::get(
        'search-schools',
        SchoolsSearchController::class
    )->name('search-schools');

    Route::get(
        'search-universities',
        UniversitiesSearchController::class
    )->name('search-universities');

    Route::get('export-pdf/{school}', ExportSchoolDetailsPDFController::class)->name('export.pdf');
});
