<?php

declare(strict_types=1);

use App\Http\Controllers\V1\CollegeStudents\CollegeStudentsIndexController;
use App\Http\Controllers\V1\CollegeStudents\PhaseCollegeStudentsIndexController;

Route::prefix('college-students')->name('college-students.')->group(function (): void {
    Route::get('',
        CollegeStudentsIndexController::class)->name('index');

    Route::get('{phase}/{academicLevel}', PhaseCollegeStudentsIndexController::class)
        ->name('phase.index');
});
