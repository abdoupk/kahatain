<?php

namespace App\Http\Resources\V1\Families;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Family */
class FamilyShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'file_number' => $this->file_number,
            'start_date' => $this->start_date,

            'branch' => $this->whenLoaded('branch', fn () => $this->branch->name),
            'zone' => $this->whenLoaded('zone', fn () => $this->zone->name),

            'orphans' => OrphanResource::collection($this->whenLoaded('orphans')),
            'spouse' => new SpouseResource($this->whenLoaded('deceased')),
            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),
            'second_sponsor' => new SecondSponsorResource($this->whenLoaded('secondSponsor')),

            'furnishings' => new FurnishingResource($this->whenLoaded('furnishings')),
            'housing' => new HousingResource($this->whenLoaded('housing')),

            'family_sponsorships' => new FamilySponsorshipResource($this->whenLoaded('sponsorships')),
            'orphans_sponsorships' => OrphanSponsorshipResource::collection($this->whenLoaded('orphansSponsorships')),
            'sponsor_sponsorships' => new SponsorSponsorshipResource($this->whenLoaded('sponsorSponsorships')),

            'preview' => new PreviewResource($this->whenLoaded('preview')),
        ];
    }
}
