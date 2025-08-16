<?php

namespace App\Http\Requests\V1\Orphans;

use App\Rules\UpdateBabyNeedsRule;
use App\Rules\UpdateOrphanClothesRule;
use Illuminate\Foundation\Http\FormRequest;

class OrphanInfosUpdateRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'health_status' => __('health_status'),
            'academic_level_id' => __('academic_level'),
            'family_status' => __('family_status'),
            'baby_milk_quantity' => __('baby_milk_quantity'),
            'diapers_quantity' => __('diapers_quantity'),
        ];
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
            'family_status' => 'nullable',
            'health_status' => 'required',
            'academic_level_id' => 'nullable|uuid|exists:academic_levels,id',
            'shoes_size' => [new UpdateOrphanClothesRule],
            'pants_size' => [new UpdateOrphanClothesRule],
            'shirt_size' => [new UpdateOrphanClothesRule],
            'gender' => 'required',
            'photo' => 'nullable|string',
            'ccp' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'note' => 'nullable',
            'baby_milk_quantity' => [new UpdateBabyNeedsRule],
            'diapers_quantity' => [new UpdateBabyNeedsRule],
            'baby_milk_type' => [new UpdateBabyNeedsRule],
            'diapers_type' => [new UpdateBabyNeedsRule],
            'institution_id' => 'nullable|uuid',
            'is_unemployed' => 'nullable|boolean',
            'is_handicapped' => 'nullable|boolean',
            'institution_type' => 'nullable|string',
            'speciality_id' => 'nullable|integer',
            'speciality_type' => 'nullable|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
