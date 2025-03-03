<?php

namespace App\Http\Resources\V1\Families;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Family */
class FamilyEditResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'start_date' => $this->start_date,

            'branch_id' => $this->branch_id,
            'zone_id' => $this->zone_id,
            'location' => $this->location,
            'residence_certificate_file' => $this->getFirstMediaUrl('residence_files'),

            'deceased' => SpouseResource::collection($this->whenLoaded('deceased')),

            'second_sponsor' => new SecondSponsorResource($this->whenLoaded('secondSponsor')),

            'furnishings' => new FurnishingResource($this->whenLoaded('furnishings')),

            'creator' => new MemberResource($this->whenLoaded('creator')),

            'housing' => new FamilyEditHousingResource($this->whenLoaded('housing')),

            'preview' => new FamilyEditPreviewResource($this->whenLoaded('preview')),
        ];
    }
}
