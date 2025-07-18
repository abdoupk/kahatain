<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilyInfosUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address' => 'required|string|min:3',
            'location.lat' => 'nullable|numeric',
            'location.lng' => 'nullable|numeric',
            'branch_id' => 'required|exists:App\Models\Branch,id',
            'zone_id' => 'required|exists:App\Models\Zone,id',
            'residence_certificate_file' => 'nullable|string',
            'last_updated_at' => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
