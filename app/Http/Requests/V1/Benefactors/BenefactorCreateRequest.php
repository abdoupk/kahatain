<?php

namespace App\Http\Requests\V1\Benefactors;

use Illuminate\Foundation\Http\FormRequest;

class BenefactorCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => ['required', 'regex:/^(06|07|05)\d{8}$/', 'unique:benefactors,phone'],
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
