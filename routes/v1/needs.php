<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Needs\GetOrphansController;
use App\Http\Controllers\V1\Needs\NeedDeleteController;
use App\Http\Controllers\V1\Needs\NeedDetailsController;
use App\Http\Controllers\V1\Needs\NeedForceDeleteController;
use App\Http\Controllers\V1\Needs\NeedRestoreController;
use App\Http\Controllers\V1\Needs\NeedShowController;
use App\Http\Controllers\V1\Needs\NeedsIndexController;
use App\Http\Controllers\V1\Needs\NeedStoreController;
use App\Http\Controllers\V1\Needs\NeedUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('needs')->name('needs.')->group(function (): void {
    Route::get(
        '',
        NeedsIndexController::class
    )
        ->name('index');

    Route::get(
        'show/{need}',
        NeedShowController::class
    )
        ->name('show');

    Route::get(
        'details/{need}',
        NeedDetailsController::class
    )
        ->name('details');

    Route::put(
        '{need}',
        NeedUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::post(
        '',
        NeedStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{need}',
        NeedDeleteController::class
    )
        ->name('destroy');

    Route::post(
        '{need}/restore',
        NeedRestoreController::class
    )
        ->name('restore')
        ->withTrashed();

    Route::delete(
        '{need}/force-delete',
        NeedForceDeleteController::class
    )
        ->name('force-delete')
        ->withTrashed();

    Route::get(
        'get-orphans',
        GetOrphansController::class
    )->name('get-orphans');
});
