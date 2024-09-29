<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Spatie\Permission\Models\Permission;

class PermissionNameExistsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Permission::where('name', explode('.', $attribute)[1])->exists()) {
            $fail(trans('validation.exists', [':attribute' => $attribute]));
        }
    }
}
