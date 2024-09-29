<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Members\MemberDeleteController;
use App\Http\Controllers\V1\Members\MemberDetailsController;
use App\Http\Controllers\V1\Members\MemberForceDeleteController;
use App\Http\Controllers\V1\Members\MemberRestoreController;
use App\Http\Controllers\V1\Members\MemberSearchController;
use App\Http\Controllers\V1\Members\MemberShowController;
use App\Http\Controllers\V1\Members\MembersIndexController;
use App\Http\Controllers\V1\Members\MemberStoreController;
use App\Http\Controllers\V1\Members\MemberUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('members')->name('members.')->group(function (): void {
    Route::get(
        '',
        MembersIndexController::class
    )
        ->name('index');

    Route::get(
        'show/{member}',
        MemberShowController::class
    )
        ->name('show');

    Route::get(
        'details/{member}',
        MemberDetailsController::class
    )
        ->name('details');

    Route::put(
        '{member}',
        MemberUpdateController::class
    )
        ->name('update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::post(
        '',
        MemberStoreController::class
    )
        ->name('store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{member}',
        MemberDeleteController::class
    )
        ->name('destroy');

    Route::post(
        '{member}/restore',
        MemberRestoreController::class
    )
        ->name('restore')->withTrashed();

    Route::get(
        'search',
        MemberSearchController::class
    )
        ->name('search');

    Route::delete(
        '{member}/force-delete',
        MemberForceDeleteController::class
    )
        ->name('force-delete')
        ->withTrashed();
});
