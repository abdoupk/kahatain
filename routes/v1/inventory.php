<?php

declare(strict_types=1);

use App\Http\Controllers\V1\Inventory\InventoryIndexController;
use App\Http\Controllers\V1\Inventory\InventoryItemsSearchController;
use App\Http\Controllers\V1\Inventory\ItemDeleteController;
use App\Http\Controllers\V1\Inventory\ItemDetailsController;
use App\Http\Controllers\V1\Inventory\ItemShowController;
use App\Http\Controllers\V1\Inventory\ItemStoreController;
use App\Http\Controllers\V1\Inventory\ItemUpdateController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::prefix('inventory')->group(function (): void {
    Route::get(
        '',
        InventoryIndexController::class
    )
        ->name('inventory.index');

    Route::post(
        '',
        ItemStoreController::class
    )
        ->name('items.store')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::get(
        'show/{item}',
        ItemShowController::class
    )
        ->name('items.show');

    Route::get(
        'details/{item}',
        ItemDetailsController::class
    )
        ->name('items.details');

    Route::put(
        '{item}',
        ItemUpdateController::class
    )
        ->name('items.update')
        ->middleware([HandlePrecognitiveRequests::class]);

    Route::delete(
        '{item}',
        ItemDeleteController::class
    )
        ->name('items.destroy');

    Route::get(
        'search',
        InventoryItemsSearchController::class
    )
        ->name('items.search');
});
