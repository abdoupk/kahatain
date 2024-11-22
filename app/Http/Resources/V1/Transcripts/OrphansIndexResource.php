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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'family_status' => $this->family_status,
            'health_status' => $this->health_status,
            'gender' => $this->gender,
            'income' => $this->income,
            'is_handicapped' => $this->is_handicapped,
            'is_unemployed' => $this->is_unemployed,
            'note' => $this->note,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'academic_level_id' => $this->academic_level_id,
        ];
    }
}
