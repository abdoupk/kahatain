<?php

namespace App\Http\Resources\V1\Schools;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Lesson */
class LessonsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject_id' => $this->subject_id,
            'academic_level_id' => $this->academic_level_id,
            'quota' => $this->quota,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];
    }
}
