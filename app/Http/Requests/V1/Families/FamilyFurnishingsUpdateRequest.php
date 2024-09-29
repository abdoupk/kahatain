<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilyFurnishingsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'television' => 'required',
            'refrigerator' => 'required',
            'fireplace' => 'required',
            'washing_machine' => 'required',
            'water_heater' => 'required',
            'oven' => 'required',
            'wardrobe' => 'required',
            'cupboard' => 'required',
            'covers' => 'required',
            'mattresses' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
