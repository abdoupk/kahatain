<?php

namespace App\Http\Resources\V1\Families;

use App\Models\SponsorSponsorship;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SponsorSponsorship */
class SponsorSponsorshipResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'medical_sponsorship' => $this->medical_sponsorship,
            'literacy_lessons' => $this->literacy_lessons,
            'direct_sponsorship' => $this->direct_sponsorship,
            'project_support' => $this->project_support,
        ];
    }
}
