<?php

namespace App\Http\Requests\V1\MonthlySponsorship;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonthlySponsorshipSettingsRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'unemployment_benefit' => __('settings.unemployment_benefit'),
            'threshold' => __('settings.threshold'),
            'categories.*.minimum' => __('validation.attributes.minimum'),
            'categories.*.maximum' => __('validation.attributes.maximum'),
            'categories.*.value' => __('the_value'),
        ];
    }

    public function rules(): array
    {
        return [
            'unemployment_benefit' => 'required|numeric|min:0|max:50000',
            'threshold' => 'required|numeric|min:0|max:50000',
            'university_scholarship_bachelor' => 'required|numeric|min:0|max:50000',
            'university_scholarship_master_one' => 'required|numeric|min:0|max:50000',
            'university_scholarship_master_two' => 'required|numeric|min:0|max:50000',
            'university_scholarship_doctorate' => 'required|numeric|min:0|max:50000',
            'association_basket_value' => 'required|numeric|min:0|max:50000',
            'categories' => 'required|array',
            'categories.*.minimum' => 'required|numeric|min:0|max:50000',
            'categories.*.maximum' => 'required|numeric|min:0|max:50000',
            'categories.*.value' => 'required|numeric|min:0|max:100',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
