<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Students\DownloadSchoolToolsListController;
use App\Http\Controllers\V1\Students\PhaseStudentsIndexController;
use App\Http\Controllers\V1\Students\StartNewSchoolYearController;
use App\Http\Controllers\V1\Students\StudentsIndexController;

Route::prefix('students')->name('students.')->group(function (): void {
    Route::get('',
        StudentsIndexController::class)->name('index');

    Route::get('{phase}/{academicLevel}', PhaseStudentsIndexController::class)
        ->name('phase.index');

    Route::delete(
        'start-new-school-year',
        StartNewSchoolYearController::class
    )->name('start-new-school-year');

    Route::get(
        'download-school-tools-list',
        DownloadSchoolToolsListController::class
    )->name('download-school-tools-list');
});
