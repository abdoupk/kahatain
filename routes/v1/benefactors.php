<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Benefactors\BenefactorDestroyController;
use App\Http\Controllers\V1\Benefactors\BenefactorDetailsController;
use App\Http\Controllers\V1\Benefactors\BenefactorIndexController;
use App\Http\Controllers\V1\Benefactors\BenefactorShowController;
use App\Http\Controllers\V1\Benefactors\BenefactorStoreController;
use App\Http\Controllers\V1\Benefactors\BenefactorUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('benefactors')->name('branches.')->group(function (): void {
    Route::get(
        '',
        BenefactorIndexController::class
    )
        ->name('benefactors.index');

    Route::get(
        'show/{benefactor}',
        BenefactorShowController::class
    )
        ->name('benefactors.show');

    Route::get(
        'details/{benefactor}',
        BenefactorDetailsController::class
    )
        ->name('benefactors.details');

    Route::put(
        '{benefactor}',
        BenefactorUpdateController::class
    )
        ->name('benefactors.update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::post(
        '',
        BenefactorStoreController::class
    )
        ->name('benefactors.store');

    Route::delete(
        '{benefactor}',
        BenefactorDestroyController::class
    )
        ->name('benefactors.destroy');
});
