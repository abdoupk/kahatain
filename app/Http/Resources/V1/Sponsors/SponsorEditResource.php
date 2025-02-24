<?php

namespace App\Http\Resources\V1\Sponsors;

use App\Http\Resources\V1\Families\IncomeResource;
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
            'phone_number' => $this->phone_number,
            'sponsor_type' => $this->sponsor_type,
            'birth_date' => $this->birth_date,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'birth_certificate_number' => $this->birth_certificate_number,
            'academic_level_id' => $this->academicLevel?->id,
            'function' => $this->function,
            'health_status' => $this->health_status,
            'diploma' => $this->diploma,
            'ccp' => $this->ccp,
            'gender' => $this->gender,
            'diploma_file' => $this->getFirstMediaUrl('diploma_files'),
            'birth_certificate_file' => $this->getFirstMediaUrl('birth_certificate_files'),
            'no_remarriage_file' => $this->getFirstMediaUrl('no_remarriage_files'),
            'photo' => $this->getFirstMediaUrl('photos'),

            'incomes' => new IncomeResource($this->whenLoaded('incomes')),
            'creator' => new MemberResource($this->whenLoaded('creator')),
        ];
    }
}
