<?php

namespace App\Http\Resources\V1\Inventory;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Inventory */
class ItemShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'type' => $this->type,
            'note' => $this->note,
            'readable_created_at' => $this->created_at->translatedFormat('d F Y H:i A'),
            'unit' => $this->unit,

            'creator' => new MemberResource($this->whenLoaded('creator')),
        ];
    }
}
