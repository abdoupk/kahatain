<?php

namespace App\Http\Resources;

use App\Models\AcademicAchievement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AcademicAchievement */
class AcademicAchievementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'academic_year' => $this->academic_year,
            'academic_level' => $this->whenLoaded('academicLevel', fn () => $this->academicLevel?->level),
            'first_trimester' => number_format($this->first_trimester, 2),
            'second_trimester' => number_format($this->second_trimester, 2),
            'third_trimester' => number_format($this->third_trimester, 2),
            'average' => number_format($this->average, 2),
            'note' => $this->note,
        ];
    }
}
