<?php

namespace App\Http\Resources\V1\Transcripts;

use App\Models\Transcript;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transcript */
class TranscriptUpdateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'trimester' => $this->trimester,
            'average' => $this->average,
            'subjects' => TranscriptSubjectsResource::collection($this->subjects),
            'academicLevel' => $this->academicLevel,
        ];
    }
}
