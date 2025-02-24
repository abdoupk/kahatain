<?php

namespace App\Http\Controllers\V1\Inventory;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Inventory\InventoryItemTrashedJob;
use App\Models\Inventory;
use Illuminate\Routing\Controllers\HasMiddleware;

class ItemDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_from_inventory'];
    }

    public function __invoke(Inventory $item)
    {
        $item->delete();

        dispatch(new InventoryItemTrashedJob($item, auth()->user()));

        return redirect()->back();
    }
}
