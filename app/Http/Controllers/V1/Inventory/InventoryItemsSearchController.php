<?php

namespace App\Http\Controllers\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;

class InventoryItemsSearchController extends Controller
{
    public function __invoke()
    {
        return search(Inventory::getModel())->get()->map(fn(Inventory $item) => [
            'id' => $item->id,
            'name' => $item->name,
        ]);
    }
}
