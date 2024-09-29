<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Notifications\NotificationMarkAsReadController;
use App\Http\Controllers\V1\Notifications\NotificationsIndexController;

Route::prefix('notifications')->name('notifications.')->group(function (): void {
    Route::get(
        '',
        NotificationsIndexController::class
    )
        ->name('index');

    Route::post(
        'mark-as-read/{id}',
        NotificationMarkAsReadController::class
    )
        ->name('mark-as-read');
});
