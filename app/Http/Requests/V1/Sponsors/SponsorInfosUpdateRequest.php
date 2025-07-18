<?php

namespace App\Http\Requests\V1\Sponsors;

use Illuminate\Foundation\Http\FormRequest;

class SponsorInfosUpdateRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'diploma' => __('diploma'),
            'health_status' => __('health_status'),
        ];
    }

    public function rules(): array
    {
        return [
            'academic_level_id' => 'nullable|uuid|exists:academic_levels,id',
            'birth_certificate_number' => 'required',
            'birth_date' => 'required',
            'ccp' => ['nullable', 'string'],
            'diploma' => 'required|string',
            'father_name' => 'required',
            'first_name' => 'required',
            'function' => 'required',
            'gender' => 'required',
            'health_status' => 'required|string',
            'last_name' => 'required',
            'mother_name' => 'required',
            'phone_number' => 'required',
            'sponsor_type' => 'required',
            'photo' => 'nullable|string',
            'diploma_file' => 'nullable|string',
            'birth_certificate_file' => 'nullable|string',
            'no_remarriage_file' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
