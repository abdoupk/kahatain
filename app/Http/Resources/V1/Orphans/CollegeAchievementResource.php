<?php

namespace App\Http\Resources\V1\Orphans;

use App\Models\CollegeAchievement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CollegeAchievement */
class CollegeAchievementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_semester' => number_format($this->first_semester, 2),
            'second_semester' => number_format($this->second_semester, 2),
            'average' => number_format($this->average, 2),
            'year' => $this->year,
            'speciality' => $this->speciality,
            'academic_level_id' => $this->academicLevel?->id,
            'university' => $this->university,
            'note' => $this->note,
            'orphan_id' => $this->orphan_id,
        ];
    }
}
