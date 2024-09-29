<?php

namespace App\Http\Resources\V1\Branches;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Branch */
class BranchShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'readable_created_at' => $this->created_at->translatedFormat('j F Y'),
            'name' => $this->name,
            'families_count' => $this->families_count,

            'city_name' => $this->whenLoaded('city', fn () => $this->city->getFullName(app()->getLocale())),
            'president' => $this->whenLoaded('president', fn () => [
                'id' => $this->president->id,
                'name' => $this->president->getName(),
            ]),
            'creator' => new MemberResource($this->whenLoaded('creator')),
        ];
    }
}
