<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateBabyNeedsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birthDate = Carbon::parse(request()->input('birth_date'));

        if ($birthDate->age <= 2) {
            if ($value == null) {
                $fail(__('validation.required', ['attribute' => __($attribute)], app()->getLocale()));
            }

            if (($attribute === 'baby_milk_quantity' || $attribute === 'diapers_quantity') && ! is_numeric($value)) {
                $fail(__('validation.integer', ['attribute' => __($attribute)], app()->getLocale()));
            }
        }
    }
}
