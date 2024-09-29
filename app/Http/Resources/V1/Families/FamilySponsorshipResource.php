<?php

namespace App\Http\Resources\V1\Families;

use App\Models\FamilySponsorship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin FamilySponsorship */
class FamilySponsorshipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'monthly_allowance' => $this->monthly_allowance,
            'ramadan_basket' => $this->ramadan_basket,
            'zakat' => $this->zakat,
            'housing_assistance' => $this->housing_assistance,
            'eid_al_adha' => $this->eid_al_adha,
        ];
    }
}
