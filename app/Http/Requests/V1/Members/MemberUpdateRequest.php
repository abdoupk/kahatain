<?php

namespace App\Http\Requests\V1\Members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->email, 'email'),
            ],
            'phone' => ['required', 'regex:/^(06|07|05)\d{8}$/', Rule::unique('users')->ignore($this->phone, 'phone'),
            ],
            'zone_id' => 'required|exists:zones,id',
            'branch_id' => 'required|exists:branches,id',
            'qualification' => 'required|string',
            'roles' => 'array|min:1',
            'roles.*' => 'required|exists:roles,uuid',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
