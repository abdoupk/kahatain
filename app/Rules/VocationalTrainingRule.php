<?php

namespace App\Rules;

use App\Models\AcademicLevel;
use App\Models\VocationalTraining;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VocationalTrainingRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $academicLevelId = request()->input('orphans')[explode('.', $attribute)[1]]['academic_level_id'];

        if (AcademicLevel::whereId($academicLevelId)->first()?->phase === 'التكوين المهني') {
            if (isset($value)) {
                if (! VocationalTraining::whereId($value)->exists()) {
                    $fail('validation.required')->translate(
                        ['attribute' => 'validation.attributes.vocational_training'],
                        app()->getLocale()
                    );
                }
            } else {
                $fail('validation.required')->translate(
                    ['attribute' => 'validation.attributes.vocational_training'],
                    app()->getLocale()
                );
            }
        }
    }
}
