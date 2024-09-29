<?php

namespace App\Http\Resources\V1\Events;

use App\Models\EventOccurrence;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin EventOccurrence */
class EventDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'title' => $this->whenLoaded('event', fn () => $this->event->title),
            'frequency' => $this->whenLoaded('event', fn () => $this->event->frequency),
            'interval' => $this->whenLoaded('event', fn () => $this->event->interval),
            'until' => $this->whenLoaded('event', fn () => $this->event->until),
            'lesson' => new LessonResource($this->whenLoaded('lesson')),
            'school' => new SchoolResource($this->whenLoaded('lesson', fn () => $this->lesson->school)),
            'subject' => new SubjectResource($this->whenLoaded('lesson', fn () => $this->lesson->subject)),
            'academic_level' => $this->whenLoaded('lesson', fn () => [
                'id' => $this->lesson->academicLevel->id,
                'name' => $this->lesson->academicLevel->level,
            ]),
            'orphans' => OrphansResource::collection($this->whenLoaded('orphans')),
            'formated_date' => formatDateFromTo($this->start_date, $this->end_date),
            'color' => $this->whenLoaded('event', fn () => $this->event->color),
            'subject_id' => $this->whenLoaded('lesson', fn () => $this->lesson->subject_id),
            'academic_level_id' => $this->whenLoaded('lesson', fn () => $this->lesson->academic_level_id),
            'school_id' => $this->whenLoaded('lesson', fn () => $this->lesson->private_school_id),
        ];
    }
}
