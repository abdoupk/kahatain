<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Committees\CommitteeDeleteController;
use App\Http\Controllers\V1\Committees\CommitteeDetailsController;
use App\Http\Controllers\V1\Committees\CommitteeForceDeleteController;
use App\Http\Controllers\V1\Committees\CommitteeRestoreController;
use App\Http\Controllers\V1\Committees\CommitteeShowController;
use App\Http\Controllers\V1\Committees\CommitteesIndexController;
use App\Http\Controllers\V1\Committees\CommitteeStoreController;
use App\Http\Controllers\V1\Committees\CommitteeUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('committees')
    ->name('committees.')
    ->group(function (): void {
        Route::get(
            '',
            CommitteesIndexController::class
        )
            ->name('index');

        Route::get(
            'show/{committee}',
            CommitteeShowController::class
        )
            ->name('show');

        Route::get(
            'details/{committee}',
            CommitteeDetailsController::class
        )
            ->name('details');

        Route::put(
            '{committee}',
            CommitteeUpdateController::class
        )
            ->name('update')
            ->middleware([HandlePrecognitiveRequests::class]);

        Route::post(
            '',
            CommitteeStoreController::class
        )
            ->name('store')
            ->middleware([HandlePrecognitiveRequests::class]);

        Route::delete(
            '{committee}',
            CommitteeDeleteController::class
        )
            ->name('destroy');

        Route::post(
            '{committee}/restore',
            CommitteeRestoreController::class
        )
            ->name('restore')
            ->withTrashed();

        Route::delete(
            '{committee}/force-delete',
            CommitteeForceDeleteController::class
        )
            ->name('force-delete')
            ->withTrashed();
    });
