<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilyInfosUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address' => 'required|string|min:3',
            'file_number' => 'required|string',
            'branch_id' => 'required|exists:App\Models\Branch,id',
            'zone_id' => 'required|exists:App\Models\Zone,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
