<?php

namespace App\Http\Resources\V1\Families;

use App\Models\FamilySponsorship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FamilySponsorship */
class FamilyEditSponsorshipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'monthly_allowance' => $this->handleValue($this->monthly_allowance),
            'ramadan_basket' => $this->handleValue($this->ramadan_basket),
            'zakat' => $this->handleValue($this->zakat),
            'housing_assistance' => $this->handleValue($this->housing_assistance),
            'eid_al_adha' => $this->handleValue($this->eid_al_adha),
        ];
    }

    private function handleValue($value): true|string
    {
        if ($value === 1 || $value === '1') {
            return true;
        }

        if ($value === null || $value === '' || $value === 0 || $value === '0') {
            return '';
        }

        return $value;
    }
}
