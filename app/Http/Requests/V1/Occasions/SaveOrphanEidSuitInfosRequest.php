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
            'note' => 'sometimes|string|max:255',
            'location' => 'sometimes',
            'user_id' => 'sometimes',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
