<?php

namespace App\Http\Requests\V1\Occasions\EidSuit;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateEidSuitInfosRequest extends FormRequest
{
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
