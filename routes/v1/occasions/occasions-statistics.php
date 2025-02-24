<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Occasions\OccasionsStatisticsIndexController;

Route::get(
    'statistics',
    OccasionsStatisticsIndexController::class
)
    ->name('statistics');
