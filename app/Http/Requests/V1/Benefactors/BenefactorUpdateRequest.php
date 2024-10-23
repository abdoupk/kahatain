<?php

namespace App\Http\Requests\V1\Benefactors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BenefactorUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => ['required', 'regex:/^(06|07|05)\d{8}$/', Rule::unique('users')->ignore($this->phone, 'phone'),
            ],
            'address' => 'nullable|string',
            'location' => 'sometimes|array',
            'location.lat' => 'nullable|numeric',
            'location.lng' => 'nullable|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
