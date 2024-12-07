<?php

namespace App\Http\Resources\V1\Transcripts;

use App\Models\School;
use App\Models\University;
use App\Models\VocationalTrainingCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin University | School | VocationalTrainingCenter */
class InstitutionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getName(),
        ];
    }
}
