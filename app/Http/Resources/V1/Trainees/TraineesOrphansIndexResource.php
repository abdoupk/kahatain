<?php

namespace App\Http\Resources\V1\Trainees;

use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Orphan */
class TraineesOrphansIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'phone_number' => formatPhoneNumber($this->phone_number),
            'academicLevel' => [
                'id' => $this->academicLevel?->id,
                'phase' => $this->academicLevel?->phase,
                'level' => $this->academicLevel?->level,
            ],
            'institution' => $this->institution->getName(),
            'speciality' => $this->speciality?->speciality,
            'ccp' => $this->ccp,
        ];
    }
}
