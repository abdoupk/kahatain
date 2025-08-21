<?php

namespace App\Http\Requests\V1\Orphans;

use Illuminate\Foundation\Http\FormRequest;

class OrphanStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'birth_date' => ['required', 'date'],
            'family_status' => ['nullable'],
            'health_status' => ['nullable'],
            'academic_level_id' => ['nullable', 'exists:academic_levels'],
            'shoes_size' => ['nullable', 'exists:shoe_sizes'],
            'pants_size' => ['nullable', 'exists:clothes_sizes'],
            'shirt_size' => ['nullable', 'exists:clothes_sizes'],
            'gender' => ['required'],
            'income' => ['nullable', 'numeric'],
            'is_handicapped' => ['boolean'],
            'is_unemployed' => ['boolean'],
            'vocational_training_id' => ['nullable'],
            'ccp' => ['nullable'],
            'phone_number' => ['nullable'],
            'institution_id' => ['nullable'],
            'institution_type' => ['nullable'],
            'speciality_id' => ['nullable', 'integer'],
            'speciality_type' => ['nullable'],
            'note' => ['nullable'],
            'family_id' => ['required'],
            'baby_milk_quantity' => ['nullable'],
            'diapers_quantity' => ['nullable'],
            'baby_milk_type' => ['nullable'],
            'diapers_type' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
