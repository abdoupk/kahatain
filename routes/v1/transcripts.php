<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Transcripts\TranscriptDeleteController;
use App\Http\Controllers\V1\Transcripts\TranscriptGeneralAverageController;
use App\Http\Controllers\V1\Transcripts\TranscriptShowController;
use App\Http\Controllers\V1\Transcripts\TranscriptsIndexController;
use App\Http\Controllers\V1\Transcripts\TranscriptStoreController;
use App\Http\Controllers\V1\Transcripts\TranscriptSubjectsController;
use App\Http\Controllers\V1\Transcripts\TranscriptUpdateController;
use App\Http\Controllers\V1\Transcripts\TranscriptUpdateGeneralAverageController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('transcripts')->name('transcripts.')->group(function (): void {
    Route::get(
        '',
        TranscriptsIndexController::class
    )->name('index');

    Route::get('show/{transcript}', TranscriptShowController::class)->name('show');

    Route::put('{transcript}', TranscriptUpdateController::class)->name('update')->middleware([HandlePrecognitiveRequests::class]);

    Route::patch('{orphan}', TranscriptUpdateGeneralAverageController::class)->name('update-general-average');

    Route::get('general-average/{orphan}', TranscriptGeneralAverageController::class)->name('general-average');

    Route::post('{orphan}', TranscriptStoreController::class)->name('store')->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{transcript}',
        TranscriptDeleteController::class
    )->name('destroy');

    Route::get('transcript-subjects/{orphan}', TranscriptSubjectsController::class)->name('transcript-subjects');
});
