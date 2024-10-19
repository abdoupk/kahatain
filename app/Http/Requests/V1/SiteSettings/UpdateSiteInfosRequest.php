<?php

namespace App\Http\Requests\V1\SiteSettings;

use App\Rules\RegistrationDomainRequiredRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateSiteInfosRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'super_admin' => __('super_admin'),
            'city_id' => __('validation.attributes.city'),
        ];
    }

    public function rules(): array
    {
        return [
            'association' => 'required|string|max:255',
            'domain' => [new RegistrationDomainRequiredRule, 'string', 'max:255'],
            'address' => 'nullable',
            'city_id' => 'nullable',
            'super_admin' => 'required|uuid|exists:users,id',
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
