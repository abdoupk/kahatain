<?php

namespace App\Http\Requests\V1\SiteSettings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalculationWeightsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'weights' => 'required',
            'percentage_of_contribution' => 'required',
            'unemployed_contribution' => 'required',
            'handicapped_contribution' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
