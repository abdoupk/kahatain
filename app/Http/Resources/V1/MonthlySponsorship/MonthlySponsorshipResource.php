<?php

namespace App\Http\Resources\V1\MonthlySponsorship;

use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Family */
class MonthlySponsorshipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'zone' => [
                'id' => $this->zone?->id,
                'name' => $this->zone?->name,
            ],
            'branch' => [
                'id' => $this->branch->id,
                'name' => $this->branch->name,
            ],
            'sponsor' => [
                'id' => $this->sponsor->id,
                'name' => $this->sponsor->getName(),
                'phone_number' => $this->sponsor->formattedPhoneNumber(),
            ],
            'orphans_count' => $this->orphans_count,
            'total_income' => $this->total_income,
            'difference_before_monthly_sponsorship' => $this->difference_before_monthly_sponsorship,
            'difference_after_monthly_sponsorship' => $this->difference_after_monthly_sponsorship,
            'monthly_sponsorship_rate' => $this->monthly_sponsorship_rate,
            'income_rate' => $this->income_rate,
            'aid' => $this->aid,
        ];
    }
}
