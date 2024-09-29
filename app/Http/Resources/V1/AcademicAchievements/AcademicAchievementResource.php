<?php

namespace App\Http\Resources\V1\AcademicAchievements;

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
            'first_trimester' => number_format($this->first_trimester, 2),
            'second_trimester' => number_format($this->second_trimester, 2),
            'third_trimester' => number_format($this->third_trimester, 2),
            'average' => number_format($this->average, 2),

            'academic_level_id' => $this->academic_level_id,
            'orphan_id' => $this->orphan_id,
            'note' => $this->note,
        ];
    }
}
