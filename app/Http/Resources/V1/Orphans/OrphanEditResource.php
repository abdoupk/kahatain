<?php

namespace App\Http\Resources\V1\Orphans;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Orphan */
class OrphanEditResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $babyNeeds = now()->diff($this->birth_date)->y < 2
            ? $this?->babyNeeds?->only(
                [
                    'baby_milk_quantity',
                    'baby_milk_type',
                    'diapers_quantity',
                    'diapers_type',
                ]
            )
            : [
                'baby_milk_quantity' => null,
                'baby_milk_type' => null,
                'diapers_quantity' => null,
                'diapers_type' => null,
            ];

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'creator' => new MemberResource($this->whenLoaded('creator')),
            'birth_date' => $this->birth_date,
            'family_status' => $this->family_status,
            'health_status' => $this->health_status,
            'academic_level_id' => $this->academic_level_id,
            ...$babyNeeds,
            'shoes_size' => $this->shoes_size,
            'pants_size' => $this->pants_size,
            'shirt_size' => $this->shirt_size,
            'gender' => $this->gender,
            'note' => $this->note,
            'income' => $this->income,
            'photo' => $this->getFirstMediaUrl('photos'),
            'institution_id' => $this->institution_id,
            'institution_type' => $this->institution_type,
            'institution' => [
                'id' => $this->institution_id,
                'name' => $this->institution?->getName(),
            ],
            'speciality_id' => $this->speciality_id,
            'speciality_type' => $this->speciality_type,
            'speciality' => [
                'id' => $this->speciality_id,
                'name' => $this->speciality?->getName(),
            ],
            'ccp' => $this->ccp,
            'is_handicapped' => $this->is_handicapped,
            'is_unemployed' => $this->is_unemployed,
            'phone_number' => $this->phone_number,
        ];
    }
}
