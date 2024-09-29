<?php

namespace App\Http\Requests\V1\Roles;

use App\Rules\PermissionNameExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class RoleCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array|min:1',
            'permissions.*' => ['required', 'boolean', new PermissionNameExistsRule()],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
