<?php

namespace App\Http\Requests\V1\SiteSettings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateSiteAwardedInfosRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'university_scholarship' => __('settings.university_scholarship'),
            'unemployment_benefit' => __('settings.unemployment_benefit'),
            'threshold' => __('settings.threshold'),
        ];
    }

    public function rules(): array
    {
        return [
            'university_scholarship' => 'required|numeric|min:0|max:50000',
            'unemployment_benefit' => 'required|numeric|min:0|max:50000',
            'threshold' => 'required|numeric|min:0|max:50000',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'domain' => Str::domain($this->domain),
        ]);
    }
}
