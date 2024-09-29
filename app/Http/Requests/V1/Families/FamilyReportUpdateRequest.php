<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

class FamilyReportUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'inspectors' => 'required|array',
            'preview_date' => 'required|date',
            'report' => 'required|string|max:100000',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
