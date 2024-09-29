<?php

/** @noinspection ALL */

namespace App\Http\Requests\V1\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationsRequest extends FormRequest
{
    /** @noinspection StaticClosureCanBeUsedInspection */
    public function rules(): array
    {
        return [
            'families_changes' => 'required|boolean',
            'branches_and_zones_changes' => 'required|boolean',
            'schools_and_lessons_changes' => 'required|boolean',
            'occasions_saves' => 'required|boolean',
            'financial_changes' => 'required|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
