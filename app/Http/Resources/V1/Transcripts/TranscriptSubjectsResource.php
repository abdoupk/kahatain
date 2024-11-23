<?php

namespace App\Http\Resources\V1\Transcripts;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Subject */
class TranscriptSubjectsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'grade' => (float) $this->pivot->grade,
            'name' => $this->getName(),
        ];
    }
}
