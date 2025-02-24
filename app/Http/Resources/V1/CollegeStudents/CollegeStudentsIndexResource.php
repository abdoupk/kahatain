<?php

namespace App\Http\Resources\V1\CollegeStudents;

use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Orphan */
class CollegeStudentsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'phone_number' => formatPhoneNumber($this->phone_number),
            'academicLevel' => $this->academicLevel->level,
            'university' => $this->institution->getName(),
            'speciality' => $this->speciality?->speciality,
            'ccp' => $this->ccp,
        ];
    }
}
