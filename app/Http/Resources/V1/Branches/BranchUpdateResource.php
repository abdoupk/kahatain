<?php

namespace App\Http\Resources\V1\Branches;

use App\Http\Resources\V1\Cities\CityResource;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Branch */
class BranchUpdateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->format('Y/m/d'),
            'name' => $this->name,

            'city_id' => $this->city_id,
            'president_id' => $this->president_id,
            'city' => new CityResource($this->city),
        ];
    }
}
