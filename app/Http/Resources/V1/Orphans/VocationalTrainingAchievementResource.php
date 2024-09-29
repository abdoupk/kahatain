<?php

namespace App\Http\Resources\V1\Orphans;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/* @mixin VocationalTrainingAchievement */
class VocationalTrainingAchievementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'year' => $this->year,
            'note' => $this->note,
            'speciality' => $this->vocationalTraining->speciality,
            'division' => $this->vocationalTraining->division,
            'institute' => $this->institute,
        ];
    }
}
