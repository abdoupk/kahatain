<?php

use App\Http\Controllers\V1\RegisteredTenantController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

Route::get(
    '/register',
    [RegisteredTenantController::class, 'create']
)->middleware(['universal', InitializeTenancyByDomain::class]);

Route::post(
    '/register',
    action: [RegisteredTenantController::class, 'store']
)->middleware(['universal', InitializeTenancyByDomain::class, HandlePrecognitiveRequests::class]);
