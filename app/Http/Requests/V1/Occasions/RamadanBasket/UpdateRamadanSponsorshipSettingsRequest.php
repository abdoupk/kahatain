<?php

namespace App\Http\Requests\V1\Occasions\RamadanBasket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRamadanSponsorshipSettingsRequest extends FormRequest
{
    public function attributes(): array
    {
        return [

            'threshold' => __('settings.threshold'),
            'categories.*.minimum' => __('validation.attributes.minimum'),
            'categories.*.maximum' => __('validation.attributes.maximum'),
            'categories.*.category' => __('the_category'),
        ];
    }

    public function rules(): array
    {
        return [
            'threshold' => 'required|numeric|min:0|max:50000',
            'categories' => 'required|array',
            'categories.*.minimum' => 'required|numeric|min:0|max:50000',
            'categories.*.maximum' => 'required|numeric|min:0|max:100000',
            'categories.*.category' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
