<?php

namespace App\Http\Requests\V1\Financial;

use Illuminate\Foundation\Http\FormRequest;

class FinancialUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable'],
            'date' => ['required', 'date'],
            'specification' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
