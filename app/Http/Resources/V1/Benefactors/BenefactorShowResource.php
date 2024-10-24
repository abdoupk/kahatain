<?php

namespace App\Http\Resources\V1\Benefactors;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Benefactor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Benefactor */
class BenefactorShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->getName(),
            'phone' => $this->phone,
            'address' => $this->address,
            'location' => $this->location,
            'sponsorships' => BenefactorSponsorshipsShowResource::collection($this->whenLoaded('sponsorships')),
            'creator' => MemberResource::make($this->whenLoaded('creator')),
            'readable_created_at' => $this->created_at->translatedFormat('j F Y'),
        ];
    }
}
