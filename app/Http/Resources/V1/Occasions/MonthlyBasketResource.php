<?php

namespace App\Http\Resources\V1\Occasions;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin FamilySponsorship */
class MonthlyBasketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->family->address,
            'zone' => [
                'id' => $this->family->zone?->id,
                'name' => $this->family->zone?->name,
            ],
            'branch' => [
                'id' => $this->family->branch->id,
                'name' => $this->family->branch->name,
            ],
            'sponsor' => [
                'id' => $this->family->sponsor->id,
                'name' => $this->family->sponsor->getName(),
                'phone_number' => $this->family->sponsor->formattedPhoneNumber(),
            ],
            'orphans_count' => $this->orphans_count,
            'total_income' => $this->family->total_income,
            'income_rate' => $this->family->income_rate,
        ];
    }
}
