<?php

namespace App\Http\Requests\V1\Committees;

use Illuminate\Foundation\Http\FormRequest;

class CommitteeCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
