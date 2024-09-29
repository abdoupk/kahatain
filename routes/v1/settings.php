<?php

declare(strict_types=1);

use App\Http\Controllers\V1\SiteSettings\SiteSettingsIndexController;

Route::prefix('settings')->name('settings.')->group(function (): void {
    Route::get(
        '',
        SiteSettingsIndexController::class
    )
        ->name('index');
});
