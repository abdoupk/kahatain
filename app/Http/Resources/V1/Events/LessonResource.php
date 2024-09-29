<?php

namespace App\Http\Resources\V1\Events;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Lesson */
class LessonResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quota' => $this->quota,
            'name' => $this->getName(),
        ];
    }
}
