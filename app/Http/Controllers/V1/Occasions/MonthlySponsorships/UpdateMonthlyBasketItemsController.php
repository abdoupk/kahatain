<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MonthlySponsorship\UpdateMonthlyBasketRequest;
use App\Jobs\V1\Occasion\MonthlyBasketItemsUpdatedJob;
use App\Models\Inventory;
use App\Models\MonthlyBasket;

class UpdateMonthlyBasketItemsController extends Controller
{
    public function __invoke(UpdateMonthlyBasketRequest $request)
    {
        $inventoryIds = collect($request->validated('items'))->pluck('inventory_id')->toArray();

        MonthlyBasket::whereNotIn('inventory_id', $inventoryIds)->delete();

        $inventoriesData = collect($request->validated('items'))
            ->map(fn ($item) => [
                'id' => $item['inventory_id'],
                'name' => $item['name'],
                'unit' => $item['unit'],
                'created_by' => auth()->user()->id,
                'tenant_id' => auth()->user()->tenant_id,
            ])
            ->unique('id')
            ->values()
            ->toArray();

        Inventory::upsert($inventoriesData, ['id'], ['name', 'unit', 'created_by', 'tenant_id']);

        $monthlyBasketData = collect($request->validated('items'))
            ->map(fn ($item) => [
                'inventory_id' => $item['inventory_id'],
                'qty_for_family' => $item['qty_for_family'],
                'status' => $item['status'],
                'tenant_id' => auth()->user()->tenant_id,
            ])
            ->toArray();

        MonthlyBasket::upsert($monthlyBasketData, ['inventory_id'], ['qty_for_family', 'status', 'tenant_id']);

        dispatch(new MonthlyBasketItemsUpdatedJob(auth()->user()));
    }
}
