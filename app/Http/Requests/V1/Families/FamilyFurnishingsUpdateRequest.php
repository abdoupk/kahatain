<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilyFurnishingsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'television' => 'nullable',
            'refrigerator' => 'nullable',
            'fireplace' => 'nullable',
            'washing_machine' => 'nullable',
            'water_heater' => 'nullable',
            'oven' => 'nullable',
            'wardrobe' => 'nullable',
            'cupboard' => 'nullable',
            'covers' => 'nullable',
            'mattresses' => 'nullable',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
