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
            'total_income' => $this->total_income,
            'amount_from_association' => $this->amount_from_association,
            'difference_after_monthly_sponsorship' => $this->difference_after_monthly_sponsorship,
            'ramadan_sponsorship_difference' => $this->ramadan_sponsorship_difference,
            'monthly_sponsorship_rate' => $this->monthly_sponsorship_rate,
            'difference_before_monthly_sponsorship' => $this->difference_before_monthly_sponsorship,
            'aggregate_red_meat_benefit' => $this->aggregate_red_meat_benefit,
            'aggregate_white_meat_benefit' => $this->aggregate_white_meat_benefit,
            'income_rate' => $this->income_rate,
            'ramadan_basket_category' => $this->ramadan_basket_category,
            'location' => $this->location,
            'orphans_count' => $this->orphans_count,

            'aid' => $this->aid,

            'branch' => $this->whenLoaded('branch', fn () => $this->branch?->name),
            'zone' => $this->whenLoaded('zone', fn () => $this->zone?->name),

            'orphans' => OrphanResource::collection($this->whenLoaded('orphans')),
            'deceased' => SpouseResource::collection($this->whenLoaded('deceased')),
            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),
            'second_sponsor' => new SecondSponsorResource($this->whenLoaded('secondSponsor')),

            'furnishings' => new FurnishingResource($this->whenLoaded('furnishings')),
            'housing' => new HousingResource($this->whenLoaded('housing')),
            ...getFormatedData($this->resource),

            'preview' => new PreviewResource($this->whenLoaded('preview')),
        ];
    }
}
