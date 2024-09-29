<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilySpouseUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'birth_date' => 'required|date',
            'death_date' => 'required|date',
            'first_name' => 'required|string',
            'function' => 'required|string',
            'income' => 'required|numeric',
            'last_name' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
