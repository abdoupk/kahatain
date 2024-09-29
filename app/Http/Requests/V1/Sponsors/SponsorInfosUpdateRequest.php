<?php

namespace App\Http\Requests\V1\Sponsors;

use Illuminate\Foundation\Http\FormRequest;

class SponsorInfosUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'academic_level_id' => 'required|integer',
            'birth_certificate_number' => 'required',
            'birth_date' => 'required',
            'ccp' => 'required',
            'diploma' => 'required',
            'father_name' => 'required',
            'first_name' => 'required',
            'function' => 'required',
            'gender' => 'required',
            'health_status' => 'required',
            'last_name' => 'required',
            'mother_name' => 'required',
            'phone_number' => 'required',
            'sponsor_type' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
