<?php

namespace App\Http\Resources\V1\VocationalTrainingAchievements;

use App\Models\VocationalTrainingAchievement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin VocationalTrainingAchievement */
class VocationalTrainingAchievementShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'note' => $this->note,
            'year' => $this->year,
            'institute' => $this->institute,
            'orphan_id' => $this->orphan_id,
            'vocational_training_id' => $this->vocational_training_id,
        ];
    }
}
