<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Zones\ZoneDeleteController;
use App\Http\Controllers\V1\Zones\ZoneDetailsController;
use App\Http\Controllers\V1\Zones\ZoneForceDeleteController;
use App\Http\Controllers\V1\Zones\ZoneRestoreController;
use App\Http\Controllers\V1\Zones\ZoneShowController;
use App\Http\Controllers\V1\Zones\ZonesIndexController;
use App\Http\Controllers\V1\Zones\ZoneStoreController;
use App\Http\Controllers\V1\Zones\ZonesWithFamiliesPositionsController;
use App\Http\Controllers\V1\Zones\ZoneUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('zones')
    ->name('zones.')
    ->group(function (): void {
        Route::get(
            '',
            ZonesIndexController::class
        )
            ->name('index');

        Route::get(
            'zones-with-families-positions',
            ZonesWithFamiliesPositionsController::class
        )
            ->name('zones-with-families-positions');

        Route::get(
            'show/{zone}',
            ZoneShowController::class
        )
            ->name('show');

        Route::get(
            'details/{zone}',
            ZoneDetailsController::class
        )
            ->name('details');

        Route::put(
            '{zone}',
            ZoneUpdateController::class
        )
            ->name('update')
            ->middleware([HandlePrecognitiveRequests::class]);

        Route::post(
            '',
            ZoneStoreController::class
        )
            ->name('store')
            ->middleware([HandlePrecognitiveRequests::class]);

        Route::delete(
            '{zone}',
            ZoneDeleteController::class
        )
            ->name('destroy');

        Route::post(
            '{zone}/restore',
            ZoneRestoreController::class
        )
            ->name('restore')
            ->withTrashed();

        Route::delete(
            '{zone}/force-delete',
            ZoneForceDeleteController::class
        )
            ->name('force-delete')
            ->withTrashed();
    });
