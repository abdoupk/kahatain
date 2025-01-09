<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Benefactors\BenefactorDestroyController;
use App\Http\Controllers\V1\Benefactors\BenefactorDetailsController;
use App\Http\Controllers\V1\Benefactors\BenefactorIndexController;
use App\Http\Controllers\V1\Benefactors\BenefactorShowController;
use App\Http\Controllers\V1\Benefactors\BenefactorSponsorshipStoreController;
use App\Http\Controllers\V1\Benefactors\BenefactorStoreController;
use App\Http\Controllers\V1\Benefactors\BenefactorUpdateController;
use App\Http\Controllers\V1\Benefactors\SearchBenefactorsController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('benefactors')->name('benefactors.')->group(function (): void {
    Route::get(
        '',
        BenefactorIndexController::class
    )
        ->name('index');

    Route::get(
        'show/{benefactor}',
        BenefactorShowController::class
    )
        ->name('show');

    Route::get(
        'details/{benefactor}',
        BenefactorDetailsController::class
    )
        ->name('details');

    Route::put(
        '{benefactor}',
        BenefactorUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::post(
        '',
        BenefactorStoreController::class
    )->middleware([HandlePrecognitiveRequests::class])
        ->name('store');

    Route::post(
        '',
        BenefactorSponsorshipStoreController::class
    )->name('store-sponsorship')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{benefactor}',
        BenefactorDestroyController::class
    )
        ->name('destroy');

    Route::get(
        'search',
        SearchBenefactorsController::class
    )
        ->name('search');
});
