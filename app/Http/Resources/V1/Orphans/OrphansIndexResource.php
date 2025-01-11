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
            'shoes_size' => $this->shoesSize->label,
            'pants_size' => $this->pantsSize->label,
            'shirt_size' => $this->shirtSize->label,
            'baby_milk_type' => $this->babyNeeds->babyMilk->name,
            'baby_milk_quantity' => $this->babyNeeds->baby_milk_quantity,
            'baby_diapers_type' => $this->babyNeeds->diapers->name,
            'baby_diapers_quantity' => $this->babyNeeds->diapers_quantity,
            'note' => $this->note,
            'age' => $this->birth_date->age,
            'income_rate' => $this->family->income_rate,
        ];
    }
}
