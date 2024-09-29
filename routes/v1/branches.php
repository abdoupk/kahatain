<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Branches\BranchDeleteController;
use App\Http\Controllers\V1\Branches\BranchDetailsController;
use App\Http\Controllers\V1\Branches\BranchesIndexController;
use App\Http\Controllers\V1\Branches\BranchForceDeleteController;
use App\Http\Controllers\V1\Branches\BranchRestoreController;
use App\Http\Controllers\V1\Branches\BranchShowController;
use App\Http\Controllers\V1\Branches\BranchStoreController;
use App\Http\Controllers\V1\Branches\BranchUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('branches')->name('branches.')->group(function (): void {
    Route::get(
        '',
        BranchesIndexController::class
    )
        ->name('index');

    Route::get(
        'show/{branch}',
        BranchShowController::class
    )
        ->name('show');

    Route::get(
        'details/{branch}',
        BranchDetailsController::class
    )->name('details');

    Route::put(
        '{branch}',
        BranchUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::post(
        '',
        BranchStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{branch}',
        BranchDeleteController::class
    )
        ->name('destroy');

    Route::post(
        '{branch}/restore',
        BranchRestoreController::class
    )
        ->name('restore')
        ->withTrashed();

    Route::delete(
        '{branch}/force-delete',
        BranchForceDeleteController::class
    )
        ->name('force-delete')
        ->withTrashed();
});
