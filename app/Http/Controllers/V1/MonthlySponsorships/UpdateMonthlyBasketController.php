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
        $inventoryIds = collect($request->items)->pluck('inventory_id')->toArray();

        MonthlyBasket::whereNotIn('inventory_id', $inventoryIds)->delete();

        $inventoriesData = collect($request->items)
            ->map(fn ($item) => [
                'id' => $item['inventory_id'],
                'name' => $item['name'],
                'created_by' => auth()->user()->id,
                'tenant_id' => auth()->user()->tenant_id,
            ])
            ->unique('id')
            ->values()
            ->toArray();

        Inventory::upsert($inventoriesData, ['id'], ['name', 'created_by', 'tenant_id']);

        $monthlyBasketData = collect($request->items)
            ->map(fn ($item) => [
                'inventory_id' => $item['inventory_id'],
                'qty_for_family' => $item['qty_for_family'],
                'status' => $item['status'],
                'tenant_id' => auth()->user()->tenant_id,
            ])
            ->toArray();

        MonthlyBasket::upsert($monthlyBasketData, ['inventory_id'], ['qty_for_family', 'status', 'tenant_id']);
    }
}
