<?php

declare(strict_types=1);

use App\Http\Controllers\V1\AcademicAchievements\AcademicAchievementsDeleteController;
use App\Http\Controllers\V1\AcademicAchievements\AcademicAchievementsShowController;
use App\Http\Controllers\V1\AcademicAchievements\AcademicAchievementsStoreController;
use App\Http\Controllers\V1\AcademicAchievements\AcademicAchievementsUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('academic-achievements')->name('academic-achievements.')->group(function (): void {
    Route::get(
        'show/{academicAchievement}',
        AcademicAchievementsShowController::class
    )->name('show');

    Route::post(
        '',
        AcademicAchievementsStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        '{academicAchievement}',
        AcademicAchievementsUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{academicAchievement}',
        AcademicAchievementsDeleteController::class
    )
        ->name('destroy');
});
