<?php

namespace App\Http\Requests\V1;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique(User::class)->ignore($this->user()?->id),
            ],
            'qualification' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:male,female'],
            'phone' => [
                'required',
                'string',
                'regex:/^(06|07|05)\d{8}$/',
                Rule::unique(User::class)->ignore($this->user()?->id),
            ],
            'address' => ['required', 'string', 'max:255'],
        ];
    }
}
