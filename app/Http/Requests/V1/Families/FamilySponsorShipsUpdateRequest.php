<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilySponsorShipsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'monthly_allowance' => 'nullable',
            'ramadan_basket' => 'nullable',
            'zakat' => 'nullable',
            'housing_assistance' => 'nullable',
            'eid_al_adha' => 'nullable',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
