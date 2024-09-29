<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilySecondSponsorUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address' => 'required|string',
            'degree_of_kinship' => 'required|string',
            'first_name' => 'required|string',
            'income' => 'required|numeric',
            'last_name' => 'required|string',
            'phone_number' => ['required', 'regex:/^(06|07|05)\d{8}$/'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
