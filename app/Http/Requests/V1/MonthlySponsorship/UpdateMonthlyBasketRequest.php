<?php

namespace App\Http\Requests\V1\MonthlySponsorship;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMonthlyBasketRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'items.*.name' => __('item_name'),
            'items.*.qty_for_family' => __('validation.attributes.qty_for_family'),
            'items.*.status' => __('validation.attributes.status'),
        ];
    }

    public function rules(): array
    {
        return [
            'items' => 'nullable|array',
            'deleted_items' => 'nullable|array',
            'items.*.inventory_id' => 'required|uuid',
            'items.*.name' => 'required|string|max:255',
            'items.*.qty_for_family' => 'required|integer',
            'items.*.unit' => 'nullable|in:kg,piece,liter',
            'items.*.status' => 'required|boolean',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
