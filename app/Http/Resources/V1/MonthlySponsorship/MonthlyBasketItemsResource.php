<?php

namespace App\Http\Resources\V1\MonthlySponsorship;

use App\Models\MonthlyBasket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin MonthlyBasket */
class MonthlyBasketItemsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->inventory->name,
            'qty_for_family' => $this->qty_for_family,
            'status' => $this->status,
            'inventory_id' => $this->inventory_id,
            'unit' => $this->inventory->unit,
        ];
    }
}
