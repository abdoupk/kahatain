<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Trainees\PhaseTraineesIndexController;
use App\Http\Controllers\V1\Trainees\TraineesIndexController;

Route::prefix('trainees')->name('trainees.')->group(function (): void {
    Route::get('',
        TraineesIndexController::class)->name('index');

    Route::get('{phase}/{academicLevel}', PhaseTraineesIndexController::class)
        ->name('phase.index');
});
