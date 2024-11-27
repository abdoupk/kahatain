<?php

namespace App\Http\Requests\V1\Schools;

use Illuminate\Foundation\Http\FormRequest;

class SchoolCreateRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('school_name')]),
            'name.max' => __('validation.max.string', ['attribute' => __('school_name'), 'max' => 255]),
            'name.string' => __('validation.string', ['attribute' => __('school_name')]),
            'lessons.*.quota.required' => __('validation.required', ['attribute' => __('validation.attributes.quota')]),
            'lessons.*.subject_id.required' => __('validation.required', ['attribute' => __('the_subject')]),
            'lessons.*.academic_level_id.required' => __('validation.required', ['attribute' => __('academic_level')]),
            'lessons.*.quota.integer' => __('validation.integer', ['attribute' => __('validation.attributes.quota')]),
            'lessons.*.subject_id.integer' => __('validation.integer', ['attribute' => __('the_subject')]),
            'lessons.*.academic_level_id.integer' => __('validation.integer', ['attribute' => __('academic_level')]),
        ];
    }

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
