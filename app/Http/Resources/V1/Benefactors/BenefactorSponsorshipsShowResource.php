<?php

namespace App\Http\Resources\V1\Benefactors;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sponsorship */
class BenefactorSponsorshipsShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'creator' => MemberResource::make($this->creator),
            'readable_created_at' => $this->created_at->translatedFormat('j F Y'),
            'recipientable' => [
                'id' => $this->recipientable->id,
                'name' => $this->recipientable->getName(),
                'recipientable_type' => $this->recipientable_type,
            ],
            'sponsorship_type' => $this->sponsorship_type,
            'until' => $this->until,
        ];
    }
}
