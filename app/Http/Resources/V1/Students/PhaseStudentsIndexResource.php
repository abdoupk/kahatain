<?php

namespace App\Http\Resources\V1\Students;

use App\Http\Resources\V1\Transcripts\TranscriptSubjectsResource;
use App\Models\Transcript;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Transcript */
class PhaseStudentsIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'average' => $this->average,
            'academic_level_id' => $this->academic_level_id,
            'orphan' => [
                'id' => $this->orphan_id,
                'name' => $this->orphan->getName(),
            ],
            'subjects' => TranscriptSubjectsResource::collection($this->subjects),
        ];
    }
}
