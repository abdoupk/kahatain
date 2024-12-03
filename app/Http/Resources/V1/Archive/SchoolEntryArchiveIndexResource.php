<?php

namespace App\Http\Resources\V1\Archive;

use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Orphan */
class SchoolEntryArchiveIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sponsor' => [
                'id' => $this->sponsor?->id,
                'name' => $this->sponsor?->getName(),
                'phone_number' => $this->sponsor?->formattedPhoneNumber(),
            ],
            'family' => [
                'zone' => [
                    'id' => $this->family->zone?->id,
                    'name' => $this->family->zone?->name,
                ],
                'address' => $this->family->address,
            ],
            'orphan' => [
                'id' => $this->id,
                'name' => $this->getName(),
                'academic_phase' => $this->academicLevel?->phase,
                'academic_level' => $this->academicLevel?->level,
            ],
        ];
    }
}
