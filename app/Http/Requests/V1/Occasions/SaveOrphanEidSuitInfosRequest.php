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
            'orphan_id' => 'required|exists:orphans,id',
            'clothes_shop_name' => 'sometimes|string|max:255',
            'clothes_shop_phone_number' => ['sometimes', 'regex:/^(06|07|05)\d{8}$/'],
            'shoes_shop_name' => 'sometimes|string|max:255',
            'shoes_shop_phone_number' => ['sometimes', 'regex:/^(06|07|05)\d{8}$/'],
            'clothes_shop_address' => 'nullable|string|max:255',
            'shoes_shop_address' => 'nullable|string|max:255',
            'shoes_shop_location' => 'nullable|array',
            'clothes_shop_location' => 'nullable|array',
            'note' => 'sometimes|string|max:255',
            'user_id' => 'sometimes',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
