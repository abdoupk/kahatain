<?php

namespace App\Http\Requests\V1\Financial;

use Illuminate\Foundation\Http\FormRequest;

class FinancialCreateRequest extends FormRequest
{
    public function messages(): array
    {
        return [
            'member_id.required' => __('validation.required', ['attribute' => __('receiving_member')]),
        ];
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'description' => ['nullable'],
            'date' => ['required', 'date'],
            'specification' => ['required'],
            'type' => ['required', 'in:income,expense'],
            'member_id' => ['required', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
