<?php

namespace App\Http\Controllers\V1\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\MonthlyBasket;
use Illuminate\Http\Request;

class UpdateMonthlyBasketController extends Controller
{
    public function __invoke(Request $request)
    {
        MonthlyBasket::whereNotIn('id', collect($request->items)->pluck('id')->toArray())->delete();

        foreach ($request->items as $item) {
            $inventory = Inventory::updateOrCreate([
                'id' => $item['id'],
            ], [
                'name' => $item['name'],
                'unit' => $item['unit'],
            ]);

            MonthlyBasket::updateOrCreate([
                'inventory_id' => $inventory->id,
            ], [
                'qty_for_family' => $item['qty_for_family'],
                'status' => $item['status'],
            ]);
        }
    }
}
