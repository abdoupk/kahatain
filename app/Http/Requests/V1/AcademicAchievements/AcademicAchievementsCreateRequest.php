<?php

namespace App\Http\Requests\V1\AcademicAchievements;

use Illuminate\Foundation\Http\FormRequest;

class AcademicAchievementsCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'academic_level_id' => 'required|integer',
            'academic_year' => 'required|integer',
            'first_trimester' => 'nullable|numeric',
            'second_trimester' => 'nullable|numeric',
            'third_trimester' => 'nullable|numeric',
            'average' => 'nullable|numeric',
            'orphan_id' => 'required|exists:orphans,id',
            'note' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
