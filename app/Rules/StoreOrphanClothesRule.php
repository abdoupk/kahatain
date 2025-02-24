<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StoreOrphanClothesRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $orphans = request()->input('orphans');

        $attributeIndex = explode('.', $attribute)[1];

        $academicLevelId = $orphans[$attributeIndex]['academic_level_id'] ?? null;

        $familyStatus = $orphans[$attributeIndex]['family_status'] ?? null;

        $birthDate = Carbon::parse($orphans[explode('.', $attribute)[1]]['birth_date']);

        $attribute = explode('.', $attribute)[2];

        if (validateClothesAttributes($birthDate, $academicLevelId, $familyStatus, $value)) {
            $fail(__('validation.required', ['attribute' => __($attribute)], app()->getLocale()));
        }
    }
}
