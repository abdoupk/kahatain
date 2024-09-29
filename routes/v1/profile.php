<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Auth\PasswordController;
use App\Http\Controllers\V1\ProfileController;
use App\Http\Controllers\V1\Settings\UpdateNotificationsSettingsController;
use App\Http\Controllers\V1\Settings\UpdateSettingsController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('profile')->name('profile.')->group(function (): void {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');

    Route::patch('/', [ProfileController::class, 'update'])
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete('/', [ProfileController::class, 'destroy'])
        ->name('destroy');

    Route::put(
        'password',
        [PasswordController::class, 'update']
    )->name('password.update')
        ->middleware([
            HandlePrecognitiveRequests::class,
        ]);

    Route::put(
        'settings',
        UpdateSettingsController::class
    )->name('settings.update');

    Route::put(
        'notifications',
        UpdateNotificationsSettingsController::class
    )->name('notifications.update');
});
