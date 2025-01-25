<?php

namespace App\Http\Resources\V1\Schools;

use App\Http\Resources\V1\Members\MemberResource;
use App\Models\Lesson;
use App\Models\PrivateSchool;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PrivateSchool */
class SchoolShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lessons_count' => $this->lessons_count,
            'readable_created_at' => $this->created_at->translatedFormat('j F Y H:i A'),
            'quota' => $this->lessons->sum('quota'),
            'creator' => new MemberResource($this->whenLoaded('creator')),
            'lessons' => $this->whenLoaded('lessons', function ($lessons) {
                return $lessons->map(fn (Lesson $lesson) => [
                    'id' => $lesson->id,
                    'quota' => $lesson->quota,
                    'subject' => $lesson->subject->getName(),
                    'academicLevel' => $lesson->academicLevel->level,
                ]);
            }),
        ];
    }
}
