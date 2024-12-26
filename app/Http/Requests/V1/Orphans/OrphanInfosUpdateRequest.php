<?php

namespace App\Http\Requests\V1\Orphans;

use Illuminate\Foundation\Http\FormRequest;

class OrphanInfosUpdateRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'pants_size.required_without' => __(
                'validation.required',
                ['attribute' => __('pants_size')]
            ),
            'shoes_size.required_without' => __(
                'validation.required',
                ['attribute' => __('shoes_size')]
            ),
            'shirt_size.required_without' => __(
                'validation.required',
                ['attribute' => __('shirt_size')]
            ),
            'baby_milk_type.required_without' => __(
                'validation.required',
                ['attribute' => __('baby_milk_type')]
            ),
            'baby_milk_quantity.required_without' => __(
                'validation.required',
                ['attribute' => __('baby_milk_quantity')]
            ),
            'diapers_type.required_without' => __(
                'validation.required',
                ['attribute' => __('diapers_type')]
            ),
            'diapers_quantity.required_without' => __(
                'validation.required',
                ['attribute' => __('diapers_quantity')]
            ),
        ];
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'family_status' => 'nullable',
            'health_status' => 'required',
            'academic_level_id' => 'required|uuid|exists:academic_levels,id',
            'shoes_size' => 'required_without:baby_milk_quantity,baby_milk_type,diapers_quantity,diapers_type',
            'pants_size' => 'required_without:baby_milk_quantity,baby_milk_type,diapers_quantity,diapers_type',
            'shirt_size' => 'required_without:baby_milk_quantity,baby_milk_type,diapers_quantity,diapers_type',
            'gender' => 'required',
            'photo' => 'nullable|string',
            'ccp' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'note' => 'nullable',
            'baby_milk_quantity' => 'required_without:shoes_size,shoes_size,shirt_size',
            'diapers_quantity' => 'required_without:shoes_size,shoes_size,shirt_size',
            'baby_milk_type' => 'required_without:shoes_size,shoes_size,shirt_size',
            'diapers_type' => 'required_without:shoes_size,shoes_size,shirt_size',
            'institution_id' => 'nullable|uuid',
            'institution_type' => 'nullable|string',
            'speciality_id' => 'nullable|integer',
            'speciality_type' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
