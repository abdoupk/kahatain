<?php

namespace App\Http\Resources\V1\Schools;

use App\Models\PrivateSchool;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PrivateSchool */
class SchoolsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quota' => $this->lessons->sum('quota'),
            'created_at' => $this->created_at,
        ];
    }
}
