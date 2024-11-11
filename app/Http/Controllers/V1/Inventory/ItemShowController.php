<?php

namespace App\Http\Controllers\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Inventory\ItemResource;
use App\Models\Inventory;
use Illuminate\Routing\Controllers\HasMiddleware;

class ItemShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:add_to_inventory'];
    }

    public function __invoke(Inventory $item)
    {
        return response()->json([
            'item' => ItemResource::make($item),
        ]);
    }
}
