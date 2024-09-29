<?php

namespace App\Http\Resources\V1\Sponsors;

use App\Http\Resources\V1\Families\IncomeResource;
use App\Http\Resources\V1\Families\SponsorSponsorshipResource;
use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sponsor */
class SponsorEditResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->formattedPhoneNumber(),
            'sponsor_type' => $this->sponsor_type,
            'birth_date' => $this->birth_date,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'birth_certificate_number' => $this->birth_certificate_number,
            'academic_level_id' => $this->academicLevel->id,
            'function' => $this->function,
            'health_status' => $this->health_status,
            'diploma' => $this->diploma,
            'ccp' => $this->ccp,
            'gender' => $this->gender,

            'incomes' => new IncomeResource($this->whenLoaded('incomes')),
            'sponsorships' => new SponsorSponsorshipResource($this->whenLoaded('sponsorships')),
            'creator' => new MemberResource($this->whenLoaded('creator')),
        ];
    }
}
