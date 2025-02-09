<?php

namespace App\Http\Resources\V1\Transcripts;

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
            'institution' => InstitutionResource::make($this->institution),
            'sponsor' => $this->whenLoaded('sponsor', fn() => [
                'id' => $this->sponsor->id,
                'name' => $this->sponsor->getName(),
                'phone_number' => $this->sponsor->formattedPhoneNumber(),
            ]),
            'academic_level' => [
                'id' => $this->academicLevel?->id,
                'phase' => $this->academicLevel?->phase,
                'level' => $this->academicLevel?->level,
                'phase_key' => $this->academicLevel?->phase_key,
            ],
            'academic_average' => (float) $this->academic_average,
            'transcripts' => $this->whenLoaded('transcripts', fn() => [
                'first_trimester' => $this->transcripts->where('trimester', 'first_trimester')->first(),
                'second_trimester' => $this->transcripts->where('trimester', 'second_trimester')->first(),
                'third_trimester' => $this->transcripts->where('trimester', 'third_trimester')->first(),
            ]),
        ];
    }
}
