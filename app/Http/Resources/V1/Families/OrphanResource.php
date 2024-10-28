<?php

namespace App\Http\Resources\V1\Families;

use App\Http\Resources\V1\Orphans\BabyResource;
use App\Models\Orphan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Orphan */
class OrphanResource extends JsonResource
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
            'shoes_size' => $this->shoesSize?->label,
            'pants_size' => $this->pantsSize?->label,
            'shirt_size' => $this->shirtSize?->label,
            'note' => $this->note,
            'gender' => $this->gender,
            'income' => $this->income,
            'baby_needs' => new BabyResource($this->whenLoaded('babyNeeds')),
        ];
    }
}
