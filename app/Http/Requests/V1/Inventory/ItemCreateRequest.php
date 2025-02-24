<?php

namespace App\Http\Requests\V1\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class ItemCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'qty' => 'required|integer',
            'note' => 'nullable',
            'type' => 'nullable',
            'unit' => 'required|in:kg,piece,liter',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
