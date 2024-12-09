<?php

namespace App\Http\Resources\V1\Families;

use App\Http\Resources\V1\Members\MemberResource;
use App\Http\Resources\V1\Sponsors\IncomeDetailResource;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sponsor */
class SponsorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'phone_number' => $this->formattedPhoneNumber(),
            'sponsor_type' => $this->sponsor_type,
            'birth_date' => $this->birth_date,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'birth_certificate_number' => $this->birth_certificate_number,
            'academic_level' => $this->academicLevel?->level,
            'function' => $this->function,
            'health_status' => $this->health_status,
            'diploma' => $this->diploma,
            'ccp' => $this->ccp,
            'creator' => new MemberResource($this->whenLoaded('creator')),
            'incomes' => new IncomeDetailResource($this->whenLoaded('incomes')),
            ...getFormatedData($this->resource),
        ];
    }
}
