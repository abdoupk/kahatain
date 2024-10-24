<?php

namespace App\Http\Requests\V1\Members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class MemberCreateRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'committees' => __('the_committees'),
        ];
    }

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
            'academic_level_id' => 'required|integer',
            'password' => ['required', Password::defaults(), 'confirmed'],
            'qualification' => 'nullable|string',
            'address' => 'required|string',
            'competences' => 'nullable|array',
            'competences.*.id' => 'nullable|exists:competences,uuid',
            'committees' => 'nullable|array',
            'committees.*.id' => 'nullable|exists:committees,uuid',
            'workplace' => 'nullable|string',
            'function' => 'nullable|string',
            'location' => 'sometimes|array',
            'location.lat' => 'nullable|numeric',
            'location.lng' => 'nullable|numeric',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:roles,uuid',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
