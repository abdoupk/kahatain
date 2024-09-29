<?php

declare(strict_types=1);

use App\Http\Controllers\V1\VocationalTrainingAchievements\VocationalTrainingAchievementsDeleteController;
use App\Http\Controllers\V1\VocationalTrainingAchievements\VocationalTrainingAchievementsShowController;
use App\Http\Controllers\V1\VocationalTrainingAchievements\VocationalTrainingAchievementsStoreController;
use App\Http\Controllers\V1\VocationalTrainingAchievements\VocationalTrainingAchievementsUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('vocational-training-achievements')
    ->name('vocational-training-achievements.')
    ->group(function (): void {
        Route::get(
            'show/{vocationalTrainingAchievement}',
            VocationalTrainingAchievementsShowController::class
        )
            ->name('show');

        Route::post(
            '',
            VocationalTrainingAchievementsStoreController::class
        )
            ->name('store')
            ->middleware([HandlePrecognitiveRequests::class]);

        Route::put(
            '{vocationalTrainingAchievement}',
            VocationalTrainingAchievementsUpdateController::class
        )
            ->name('update')
            ->middleware([HandlePrecognitiveRequests::class]);

        Route::delete(
            '{vocationalTrainingAchievement}',
            VocationalTrainingAchievementsDeleteController::class
        )
            ->name('destroy');
    });
