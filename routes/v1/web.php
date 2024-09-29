<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// for now, we redirect to register before create landing page.
Route::get('/', fn () => redirect('/register'));
