<?php

namespace App\Http\Resources\V1\Orphans;

use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Orphan */
class OrphansIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'birth_date' => $this->birth_date,
            'family_status' => $this->family_status,
            'health_status' => $this->health_status,
            'academic_level' => $this->academicLevel?->level,
            'academic_level_phase' => $this->academicLevel?->phase,
            'shoes_size' => $this->shoes_size,
            'pants_size' => $this->pants_size,
            'shirt_size' => $this->shirt_size,
            'note' => $this->note,
        ];
    }
}
