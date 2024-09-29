<?php

namespace App\Http\Controllers\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Inventory\ItemCreateRequest;
use App\Jobs\V1\Inventory\InventoryItemCreatedJob;
use App\Models\Inventory;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ItemStoreController extends Controller implements HasMiddleware
{
    public function __invoke(ItemCreateRequest $request): Response
    {
        $item = Inventory::create($request->validated());

        dispatch(new InventoryItemCreatedJob($item, auth()->user()));

        return response('', 201);
    }
    public static function middleware()
    {
        return ['can:delete_from_inventory'];
    }
}
