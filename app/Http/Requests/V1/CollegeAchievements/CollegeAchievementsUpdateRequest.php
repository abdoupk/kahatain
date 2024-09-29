<?php

namespace App\Http\Requests\V1\CollegeAchievements;

use Illuminate\Foundation\Http\FormRequest;

class CollegeAchievementsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'academic_level_id' => 'required|integer',
            'year' => 'required|integer',
            'first_semester' => 'nullable|numeric',
            'second_semester' => 'nullable|numeric',
            'average' => 'nullable|numeric',
            'orphan_id' => 'required|exists:orphans,id',
            'speciality' => 'required|string',
            'university' => 'required|string',
            'note' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
