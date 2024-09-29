<?php

namespace App\Http\Resources\V1\Schools;

use App\Models\PrivateSchool;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PrivateSchool */
class SchoolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lessons' => LessonsResource::collection($this->whenLoaded('lessons')),
        ];
    }
}
