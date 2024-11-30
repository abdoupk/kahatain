<?php

namespace App\Http\Requests\V1\Schools;

use Illuminate\Foundation\Http\FormRequest;

class SchoolUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'lessons.*.quota' => 'required|integer',
            'lessons.*.subject_id' => 'required|integer',
            'lessons.*.academic_level_id' => 'required|uuid|exists:academic_levels,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
