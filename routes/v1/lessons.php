<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Events\LessonShowController;
use App\Http\Controllers\V1\Lessons\LessonDeleteController;
use App\Http\Controllers\V1\Lessons\LessonDetailsController;
use App\Http\Controllers\V1\Lessons\LessonsIndexController;
use App\Http\Controllers\V1\Lessons\LessonStoreController;
use App\Http\Controllers\V1\Lessons\LessonUpdateController;
use App\Http\Controllers\V1\Lessons\LessonUpdateDatesController;
use App\Http\Controllers\V1\Lessons\ListOrphansController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('lessons')->name('lessons.')->group(function (): void {
    Route::get(
        '',
        LessonsIndexController::class
    )
        ->name('index');

    Route::get(
        'list-orphans',
        ListOrphansController::class
    )
        ->name('list-orphans');

    Route::post(
        '',
        LessonStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        '{eventOccurrence}',
        LessonUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::put(
        'update-dates/{lesson}',
        LessonUpdateDatesController::class
    )
        ->name('update-dates');

    Route::get(
        'edit/{eventOccurrence}',
        LessonDetailsController::class
    )
        ->name('edit');

    Route::get(
        'show/{eventOccurrence}',
        LessonShowController::class
    )
        ->name('show');

    Route::delete(
        '{lesson}',
        LessonDeleteController::class
    )
        ->name('destroy');
});
