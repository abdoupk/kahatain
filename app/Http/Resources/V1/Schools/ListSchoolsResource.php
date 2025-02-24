<?php

namespace App\Http\Resources\V1\Schools;

use App\Models\Lesson;
use App\Models\PrivateSchool;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin PrivateSchool */
class ListSchoolsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subjects' => $this->whenLoaded('subjects')->map(fn (Lesson $lesson) => [
                'id' => $lesson->subject->id ?? $this->id,
                'name' => $lesson->subject->getName().' - '.$lesson->academicLevel?->level,
                'quota' => $lesson->quota,
                'start_date' => $lesson->start_date,
                'end_date' => $lesson->end_date,
                'academic_level_id' => $lesson->academic_level_id,
            ]),
        ];
    }
}
