<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Roles\RoleDeleteController;
use App\Http\Controllers\V1\Roles\RoleShowController;
use App\Http\Controllers\V1\Roles\RolesIndexController;
use App\Http\Controllers\V1\Roles\RoleStoreController;
use App\Http\Controllers\V1\Roles\RoleUpdateController;

Route::prefix('roles')->name('roles.')->group(function (): void {
    Route::get(
        '',
        RolesIndexController::class
    )
        ->name('index');

    Route::post(
        '',
        RoleStoreController::class
    )
        ->name('store');

    Route::put(
        '{role}',
        RoleUpdateController::class
    )
        ->name('update');

    Route::get(
        'show/{role}',
        RoleShowController::class
    )
        ->name('show');

    Route::delete(
        '{role}',
        RoleDeleteController::class
    )
        ->name('destroy');
});
