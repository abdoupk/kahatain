<?php

namespace App\Http\Controllers\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Inventory\ItemUpdateRequest;
use App\Jobs\V1\Inventory\InventoryItemUpdatedJob;
use App\Models\Inventory;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ItemUpdateController extends Controller implements HasMiddleware
{
    public function __invoke(ItemUpdateRequest $request, Inventory $item): Response
    {
        $item->update($request->validated());

        dispatch(new InventoryItemUpdatedJob($item, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:update_inventory'];
    }
}
