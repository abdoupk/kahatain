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
            'zone_id' => 'nullable|exists:zones,id',
            'branch_id' => 'nullable|exists:branches,id',
            'qualification' => 'nullable|string',
            'address' => 'required|string',
            'competences' => 'nullable|array',
            'competences.*.id' => 'nullable|uuid',
            'committees' => 'nullable|array',
            'committees.*.id' => 'nullable|exists:committees,id',
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
