<?php

namespace App\Rules;

use App\Models\Domain;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class RegistrationDomainRequiredRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Domain::whereDomain($value)->when(tenant('id'), function ($query): void {
            $query->where('tenant_id', '!=', tenant('id'));
        })->exists()) {
            $fail(trans('validation.unique', [':attribute' => $attribute]));
        }

        if (! Str::remove('.'.config('tenancy.central_domains')[0], $value)) {
            $fail(trans('validation.required', [':attribute' => $attribute]));
        }
    }
}
