<?php

namespace App\Http\Resources\V1\Orphans;

use App\Models\Baby;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Baby */
class BabyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'baby_milk_quantity' => $this->baby_milk_quantity,
            'baby_milk_type' => $this->babyMilk?->name,
            'diapers_quantity' => $this->diapers_quantity,
            'diapers_type' => $this->diapers?->name,
        ];
    }
}
