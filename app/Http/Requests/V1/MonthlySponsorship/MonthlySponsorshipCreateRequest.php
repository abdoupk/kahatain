<?php

namespace App\Http\Requests\V1\MonthlySponsorship;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MonthlySponsorshipCreateRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'shop.name.required_if' => __('validation.required_if', ['attribute' => __('shop.name'), 'other' => __('sponsorship_type'), 'value' => __('sponsorship_type.monthly_basket')]),
            'shop.address.required_if' => __('validation.required_if', ['attribute' => __('shop.address'), 'other' => __('sponsorship_type'), 'value' => __('sponsorship_type.monthly_basket')]),
            'shop.phone.required_if' => __('validation.required_if', ['attribute' => __('shop.phone'), 'other' => __('sponsorship_type'), 'value' => __('sponsorship_type.monthly_basket')]),
        ];
    }

    public function attributes(): array
    {
        return [
            'benefactor.id' => __('the_benefactor'),
            'sponsorship_type' => __('sponsorship_type'),
            'shop.name' => __('shop.name'),
            'shop.address' => __('shop.address'),
            'shop.phone' => __('shop.phone'),
        ];
    }

    public function rules(): array
    {
        $requiredShop = 'required_if:sponsorship_type,monthly_basket';

        return [
            'amount' => 'required|integer',
            'benefactor.id' => 'required|uuid|exists:benefactors,id',
            'recipientable_id' => 'required|uuid',
            'recipientable_type' => 'required|string',
            'sponsorship_type' => ['required', 'string', Rule::in(['monthly_basket', 'educational_sponsorship', 'grant', 'social_sponsorship'])],
            'shop' => $requiredShop,
            'shop.name' => $requiredShop,
            'shop.address' => $requiredShop,
            'shop.phone' => $requiredShop,
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
