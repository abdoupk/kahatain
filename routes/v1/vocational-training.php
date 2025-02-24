<?php

declare(strict_types=1);

use App\Http\Controllers\V1\VocationalTraining\SearchVocationalTrainingCentersController;
use App\Http\Controllers\V1\VocationalTraining\SearchVocationalTrainingSpecialitiesController;

Route::prefix('vocational-training')->name('vocational-training.')->group(function (): void {
    Route::get(
        'search-vocational-training-specialities',
        SearchVocationalTrainingCentersController::class
    )->name('search-vocational-training-centers');

    Route::get(
        'search',
        SearchVocationalTrainingSpecialitiesController::class
    )
        ->name('search');
});
