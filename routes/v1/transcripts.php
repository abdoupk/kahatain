<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Transcripts\TranscriptShowController;
use App\Http\Controllers\V1\Transcripts\TranscriptsIndexController;
use App\Http\Controllers\V1\Transcripts\TranscriptStoreController;
use App\Http\Controllers\V1\Transcripts\TranscriptSubjectsController;
use App\Http\Controllers\V1\Transcripts\TranscriptUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('transcripts')->name('transcripts.')->group(function (): void {
    Route::get(
        '',
        TranscriptsIndexController::class
    )->name('index');

    Route::get('show/{transcript}', TranscriptShowController::class)->name('show');

    Route::put('{transcript}', TranscriptUpdateController::class)->name('update')->middleware([HandlePrecognitiveRequests::class]);

    Route::post('{orphan}', TranscriptStoreController::class)->name('store')->middleware([HandlePrecognitiveRequests::class]);

    Route::get('transcript-subjects/{orphan}', TranscriptSubjectsController::class)->name('transcript-subjects');
});
