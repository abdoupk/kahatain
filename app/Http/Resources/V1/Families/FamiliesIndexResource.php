<?php

namespace App\Http\Resources\V1\Families;

use App\Http\Resources\V1\Zones\ZoneResource;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Family
 */
class FamiliesIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'sponsor' => [
                'id' => $this->sponsor->id,
                'name' => $this->sponsor->getName(),
            ],
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'start_date' => $this->start_date,
            'file_number' => $this->file_number,
        ];
    }
}
