<?php

namespace App\Http\Resources\V1\Students;

use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin Orphan */
class StudentsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
            'academicLevel' => $this->academicLevel->level,
            'institution' => $this->institution->getName(),
            'address' => $this->family->address,
            'zone' => [
                'id' => $this->family->zone?->id,
                'name' => $this->family->zone?->name,
            ],
            'branch' => [
                'id' => $this->family->branch?->id,
                'name' => $this->family->branch?->name,
            ],
            'sponsor' => [
                'id' => $this->sponsor?->id,
                'name' => $this->sponsor?->getName(),
                'phone_number' => $this->sponsor?->formattedPhoneNumber(),
            ],
        ];
    }
}
