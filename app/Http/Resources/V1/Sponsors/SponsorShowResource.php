<?php

namespace App\Http\Resources\V1\Sponsors;

use App\Http\Resources\V1\Branches\BranchesResource;
use App\Http\Resources\V1\Families\IncomeResource;
use App\Http\Resources\V1\Members\MemberResource;
use App\Http\Resources\V1\Zones\ZoneResource;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sponsor */
class SponsorShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_number' => $this->family->file_number,
            'start_date' => $this->family->start_date,
            'name' => $this->getName(),
            'address' => $this->family->address,
            'phone_number' => $this->formattedPhoneNumber(),
            'birth_date' => $this->birth_date,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'academic_level' => $this->academicLevel?->level,
            'function' => $this->function,
            'health_status' => $this->health_status,
            'diploma' => $this->diploma,
            'ccp' => $this->ccp,
            'gender' => $this->gender,
            'orphans_count' => $this->orphans_count,
            'birth_certificate_number' => $this->birth_certificate_number,
            'sponsor_type' => $this->sponsor_type,

            'incomes' => new IncomeResource($this->whenLoaded('incomes')),
            'zone' => new ZoneResource($this->family->zone),
            'branch' => new BranchesResource($this->family->branch),
            'creator' => new MemberResource($this->whenLoaded('creator')),
        ];
    }
}
