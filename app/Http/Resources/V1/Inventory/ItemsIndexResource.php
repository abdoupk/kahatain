<?php

namespace App\Http\Resources\V1\Inventory;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Inventory */
class ItemsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'unit' => $this->unit,
            'note' => $this->note,
            'created_at' => $this->created_at,
        ];
    }
}
