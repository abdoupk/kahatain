<?php

namespace App\Http\Resources\V1\Benefactors;

use App\Models\Benefactor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Benefactor */
class BenefactorUpdateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'address' => $this->address,
            'location' => $this->location,
            'sponsorships' => BenefactorSponsorshipsShowResource::collection($this->whenLoaded('sponsorships')),
        ];
    }
}
