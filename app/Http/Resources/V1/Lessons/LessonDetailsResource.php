<?php

namespace App\Http\Resources\V1\Lessons;

use App\Http\Resources\V1\Schools\LessonsResource;
use App\Models\EventOccurrence;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EventOccurrence */
class LessonDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,

            'lesson' => new LessonsResource($this->whenLoaded('lesson')),
            'orphans' => OrphansResource::collection($this->whenLoaded('orphans')),
        ];
    }
}
