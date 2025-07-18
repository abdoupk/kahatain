<?php

namespace App\Http\Resources\V1\Occasions;

use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Orphan
 */
class SchoolEntryResource extends JsonResource
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
                'income_rate' => $this->family->income_rate,
                'last_updated_at' => $this->family->last_updated_at,
            ],
            'orphan' => [
                'id' => $this->id,
                'name' => $this->getName(),
                'academic_phase' => $this->academicLevel?->phase,
                'academic_level' => $this->academicLevel?->level,
                'academic_average' => $this->academic_average,
            ],
        ];
    }
}
