<?php

namespace App\Http\Requests\V1\VocationalTrainingAchievements;

use Illuminate\Foundation\Http\FormRequest;

class VocationalTrainingAchievementsCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vocational_training_id' => 'required|integer',
            'year' => 'required|integer',
            'orphan_id' => 'required|exists:orphans,id',
            'note' => 'nullable|string',
            'institute' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
