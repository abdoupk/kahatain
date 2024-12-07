<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique('users')->where(function ($query) {
                    $query->where('tenant_id', tenant('id'));
                })->ignore(auth()->id()),
            ],
            'competences' => ['required', 'array', 'min:1'],
            'gender' => ['required', 'in:male,female'],
            'phone' => [
                'required',
                'string',
                'regex:/^(06|07|05)\d{8}$/',
                Rule::unique('users')->where(function ($query) {
                    $query->where('tenant_id', tenant('id'));
                })->ignore(auth()->id()),
            ],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
