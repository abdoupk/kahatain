<?php

namespace App\Http\Resources\V1\Inventory;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Inventory */
class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'qty_for_family' => $this->qty_for_family,
            'unit' => $this->unit,
            'note' => $this->note,
        ];
    }
}
