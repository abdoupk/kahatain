<?php

namespace App\Http\Resources\V1\Zones;

use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Zone
 */
class ZonesIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'families_count' => $this->families_count,
            'created_at' => Carbon::createFromTimeString($this->created_at)->diffForHumans(),
        ];
    }
}
