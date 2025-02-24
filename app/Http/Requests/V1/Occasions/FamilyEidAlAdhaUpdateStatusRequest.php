<?php

namespace App\Http\Requests\V1\Occasions;

use Illuminate\Foundation\Http\FormRequest;

class FamilyEidAlAdhaUpdateStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|in:sacrificed,benefit,dont_benefit,meat,benefactor',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
