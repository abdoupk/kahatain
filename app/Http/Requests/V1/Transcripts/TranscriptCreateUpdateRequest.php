<?php

namespace App\Http\Requests\V1\Transcripts;

use Illuminate\Foundation\Http\FormRequest;

class TranscriptCreateUpdateRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'average.required' => __('validation.required', ['attribute' => __('the_trimester_average')]),
            'average.numeric' => __('validation.numeric', ['attribute' => __('the_trimester_average')]),
            'subjects.*.grade.required_unless' => __('validation.required', ['attribute' => __('validation.attributes.grade')]),
        ];
    }

    public function rules(): array
    {
        return [
            'trimester' => 'required|in:first_trimester,second_trimester,third_trimester',
            'subjects.*.id' => 'required|exists:subjects,id',
            // 'subjects.*.grade' => 'required_unless:subjects.*.id,26,8,4|nullable|numeric',
            'subjects.*.grade' => 'nullable|numeric',
            'average' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
