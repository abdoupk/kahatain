<?php

namespace App\Http\Resources\V1\Sponsors;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Sponsor */
class SponsorsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'phone_number' => $this->formattedPhoneNumber(),
            'birth_date' => $this->birth_date,
            'academic_level' => $this->academicLevel?->level,
            'academic_level_phase' => $this->academicLevel?->phase,
            'function' => $this->function,
            'health_status' => $this->health_status,
            'sponsor_type' => $this->sponsor_type,
        ];
    }
}
