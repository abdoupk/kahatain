<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateOrphanClothesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birthDate = request()->input('birth_date');
        $academicLevelId = request()->input('academic_level_id');
        $familyStatus = request()->input('family_status');

        if (validateClothesAttributes($birthDate, $academicLevelId, $familyStatus, $value)) {
            $fail(__('validation.required', ['attribute' => __($attribute)], app()->getLocale()));
        }
    }
}
