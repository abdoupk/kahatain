<?php

namespace App\Http\Requests\V1\Occasions;

use Illuminate\Foundation\Http\FormRequest;

class SaveMeatDistributionToArchiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'families' => 'required|array|min:1',
            'meat_type' => 'required|in:white_meat,red_meat',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
