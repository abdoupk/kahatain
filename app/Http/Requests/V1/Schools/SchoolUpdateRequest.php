<?php

namespace App\Http\Requests\V1\Schools;

use Illuminate\Foundation\Http\FormRequest;

class SchoolUpdateRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'name' => __('school_name'),
            'lessons.*.subject_id' => __('the_subject'),
            'lessons.*.academic_level_id' => __('academic_level'),
            'lessons.*.quota' => __('validation.attributes.quota'),
            'lessons.*.start_date' => __('validation.attributes.start_date'),
            'lessons.*.end_date' => __('validation.attributes.end_date'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'lessons.*.quota' => 'required|integer',
            'lessons.*.subject_id' => 'required|integer',
            'lessons.*.start_date' => 'required|date',
            'lessons.*.end_date' => 'required|date',
            'lessons.*.academic_level_id' => 'required|uuid|exists:academic_levels,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
