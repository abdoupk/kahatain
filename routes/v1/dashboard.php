<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Dashboard\DashboardController;

Route::get(
    '',
    DashboardController::class
)
    ->name('dashboard');
