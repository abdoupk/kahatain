<?php

declare(strict_types=1);

use App\Http\Controllers\V1\CollegeAchievements\CollegeAchievementsDeleteController;
use App\Http\Controllers\V1\CollegeAchievements\CollegeAchievementsShowController;
use App\Http\Controllers\V1\CollegeAchievements\CollegeAchievementsStoreController;
use App\Http\Controllers\V1\CollegeAchievements\CollegeAchievementsUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('college-achievements')->name('college-achievements.')->group(function (): void {
    Route::get(
        'show/{collegeAchievement}',
        CollegeAchievementsShowController::class
    )
        ->name('show');

    Route::post(
        '',
        CollegeAchievementsStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        '{collegeAchievement}',
        CollegeAchievementsUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{collegeAchievement}',
        CollegeAchievementsDeleteController::class
    )
        ->name('destroy');
});
