<?php

namespace App\Http\Requests\V1\Members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class MemberCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'regex:/^(06|07|05)\d{8}$/', 'unique:users,phone'],
            'zone_id' => 'required|exists:zones,id',
            'branch_id' => 'required|exists:branches,id',
            'password' => ['required', Password::defaults(), 'confirmed'],
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
