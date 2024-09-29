<?php

namespace App\Http\Requests\V1\Roles;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
