<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreBabyNeedsRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birthDate = Carbon::parse(request()->input('orphans')[explode('.', $attribute)[1]]['birth_date']);

        $attribute = explode('.', $attribute)[2];

        if ($birthDate->age <= 2) {
            if ($value === null) {
                $fail(__('validation.required', ['attribute' => __($attribute)], app()->getLocale()));
            }
        }
    }
}
