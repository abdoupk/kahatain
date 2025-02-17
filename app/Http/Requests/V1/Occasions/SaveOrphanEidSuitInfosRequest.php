<?php

namespace App\Http\Requests\V1\Occasions;

use App\Models\OrphanEidSuit;
use Illuminate\Foundation\Http\FormRequest;

/* @mixin OrphanEidSuit */
class SaveOrphanEidSuitInfosRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'clothes_shop_name' => 'sometimes|nullable|string|max:255',
            'clothes_shop_phone_number' => ['sometimes', 'nullable', 'regex:/^(06|07|05)\d{8}$/'],
            'shoes_shop_name' => 'sometimes|nullable|string|max:255',
            'shoes_shop_phone_number' => ['sometimes', 'nullable', 'regex:/^(06|07|05)\d{8}$/'],
            'clothes_shop_address' => 'sometimes|nullable|string|max:255',
            'shoes_shop_address' => 'sometimes|nullable|string|max:255',
            'shoes_shop_location' => 'sometimes|nullable|array',
            'clothes_shop_location' => 'sometimes|nullable|array',
            'note' => 'sometimes|nullable|string|max:255',
            'user_id' => 'sometimes',
            'shirt_completed' => 'sometimes|nullable|boolean',
            'shoes_completed' => 'sometimes|nullable|boolean',
            'pants_completed' => 'sometimes|nullable|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
