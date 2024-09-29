<?php

namespace App\Http\Requests\V1\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'qty' => 'required|integer',
            'qty_for_family' => 'required|integer|lt:qty',
            'note' => 'nullable',
            'unit' => 'required|in:kg,piece,liter',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
