<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilyHousingUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'housing_type.value' => 'required',
            'housing_type.name' => 'required',
            'number_of_rooms' => 'required|numeric',
            'housing_receipt_number' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
