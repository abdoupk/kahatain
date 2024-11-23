<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Students\PhaseStudentsIndexController;
use App\Http\Controllers\V1\Students\StudentsIndexController;

Route::prefix('students')->name('students.')->group(function (): void {
    Route::get('',
        StudentsIndexController::class)->name('index');

    Route::get('{phase}/{academicLevel}', PhaseStudentsIndexController::class)

//        ->where('academicLevel', '[0-9a-fA-F\-]{36}')
        ->name('phase');
});
