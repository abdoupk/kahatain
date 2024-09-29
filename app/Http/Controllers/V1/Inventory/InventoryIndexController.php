<?php

namespace App\Http\Controllers\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Inventory\ItemsIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class InventoryIndexController extends Controller implements HasMiddleware
{
    public function __invoke()
    {
        return Inertia::render('Tenant/inventory/index/InventoryIndexPage', [
            'items' => ItemsIndexResource::collection(getInventoryItems()),
            'params' => getParams(),
        ]);
    }

    public static function middleware()
    {
        return ['can:list_items'];
    }
}
