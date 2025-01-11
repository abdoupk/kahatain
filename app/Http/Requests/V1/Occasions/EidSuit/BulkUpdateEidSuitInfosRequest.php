<?php

namespace App\Http\Requests\V1\Occasions\EidSuit;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateEidSuitInfosRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'clothes_shop_name' => __('clothes_shop_name'),
            'clothes_shop_address' => __('clothes_shop_address'),
            'clothes_shop_phone_number' => __('clothes_shop_phone_number'),
            'shoes_shop_name' => __('shoes_shop_name'),
            'shoes_shop_address' => __('shoes_shop_address'),
            'shoes_shop_location' => __('shoes_shop_location'),
            'clothes_shop_location' => __('clothes_shop_location'),
            'shoes_shop_phone_number' => __('shoes_shop_phone_number'),
            'designated_member' => __('designated_member'),
            'note' => __('note'),
        ];
    }

    public function rules(): array
    {
        return [
            'ids' => ['required', 'array'],
            'ids.*' => ['required', 'exists:orphans,id'],
            'clothes_shop_name' => 'nullable|string|max:255',
            'clothes_shop_address' => 'nullable|string|max:255',
            'clothes_shop_phone_number' => ['nullable', 'regex:/^(06|07|05)\d{8}$/'],
            'shoes_shop_name' => 'nullable|string|max:255',
            'shoes_shop_address' => 'nullable|string|max:255',
            'shoes_shop_location' => 'nullable|array',
            'clothes_shop_location' => 'nullable|array',
            'shoes_shop_phone_number' => ['nullable', 'regex:/^(06|07|05)\d{8}$/'],
            'designated_member' => 'required|exists:users,id',
            'note' => 'nullable|string|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
