<?php

namespace App\Http\Requests\V1\Lessons;

use Illuminate\Foundation\Http\FormRequest;

/* @mixin Event */
class LessonUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'color' => 'required|hex_color',
            'until' => 'nullable|date',
            'orphans.*' => 'required|exists:App\Models\Orphan,id',
            'school_id' => 'required|exists:App\Models\PrivateSchool,id',
            'subject_id' => 'required|integer',
            'academic_level_id' => 'required|uuid|exists:academic_levels,id',
            'frequency' => 'nullable|in:weekly,monthly,daily|required_with:interval',
            'interval' => 'nullable|integer|min:1|required_with:frequency',
            'update_this_and_all_coming' => 'required|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
