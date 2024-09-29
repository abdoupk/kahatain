<?php

namespace App\Http\Resources\V1\Families;

use App\Models\Furnishing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Furnishing */
class FurnishingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'television' => $this->television,
            'refrigerator' => $this->refrigerator,
            'fireplace' => $this->fireplace,
            'washing_machine' => $this->washing_machine,
            'water_heater' => $this->water_heater,
            'oven' => $this->oven,
            'wardrobe' => $this->wardrobe,
            'cupboard' => $this->cupboard,
            'covers' => $this->covers,
            'mattresses' => $this->mattresses,
            'other_furnishings' => $this->other_furnishings,
        ];
    }
}
