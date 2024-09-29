<?php

namespace App\Http\Requests\V1\Branches;

use Illuminate\Foundation\Http\FormRequest;

class BranchCreateUpdateRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'name' => __('branch_name'),
            'city_id' => __('commune'),
            'president_id' => __('branch_president'),
            'created_at' => __('validation.attributes.created_at'),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'president_id' => 'required|exists:users,id',
            'created_at' => 'required|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
