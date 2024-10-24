<?php

declare(strict_types=1);

use App\Http\Controllers\V1\AcademicLevel\AcademicLevelIndexController;
use App\Http\Controllers\V1\Branches\ListBranchesController;
use App\Http\Controllers\V1\Competences\CompetenceIndexController;
use App\Http\Controllers\V1\List\ListBabyMilkController;
use App\Http\Controllers\V1\List\ListBenefactorsController;
use App\Http\Controllers\V1\List\ListClothesSizesController;
use App\Http\Controllers\V1\List\ListCommitteesController;
use App\Http\Controllers\V1\List\ListDiapersController;
use App\Http\Controllers\V1\List\ListMembersController;
use App\Http\Controllers\V1\List\ListRolesController;
use App\Http\Controllers\V1\List\ListSchoolsController;
use App\Http\Controllers\V1\List\ListShoesSizesController;
use App\Http\Controllers\V1\List\ListSubjectsController;
use App\Http\Controllers\V1\VocationalTraining\VocationalTrainingIndexController;
use App\Http\Controllers\V1\Zones\ListZonesController;

Route::prefix('list')->name('list.')->group(function (): void {
    Route::get(
        'shoes-sizes',
        ListShoesSizesController::class
    )->name('shoes-sizes');

    Route::get(
        'clothes-sizes',
        ListClothesSizesController::class
    )->name('clothes-sizes');

    Route::get(
        'roles',
        ListRolesController::class
    )->name('roles');

    Route::get(
        'members',
        ListMembersController::class
    )->name('members');

    Route::get(
        'subjects',
        ListSubjectsController::class
    )->name('subjects');

    Route::get(
        'schools',
        ListSchoolsController::class
    )->name('schools');

    Route::get(
        'list-branches',
        ListBranchesController::class
    )->name('branches');

    Route::get(
        'list-zones',
        ListZonesController::class
    )->name('zones');

    Route::get(
        'baby-milk',
        ListBabyMilkController::class
    )->name('baby-milk');

    Route::get(
        'diapers',
        ListDiapersController::class
    )->name('diapers');

    Route::get(
        'academic-levels',
        AcademicLevelIndexController::class
    )
        ->name('academic-levels');

    Route::get(
        'vocational-training',
        VocationalTrainingIndexController::class
    )->name('vocational-trainings-specialities');

    Route::get(
        'competences',
        CompetenceIndexController::class
    )->name('competences');

    Route::get(
        'committees',
        ListCommitteesController::class
    )->name('committees');

    Route::get(
        'benefactors',
        ListBenefactorsController::class
    )->name('benefactors');
});
