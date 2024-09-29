<?php

use App\Http\Controllers\V1\RegisteredTenantController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::get(
    '/register',
    [RegisteredTenantController::class, 'create']
);

Route::post(
    '/register',
    action: [RegisteredTenantController::class, 'store']
)
    ->middleware([HandlePrecognitiveRequests::class]);
