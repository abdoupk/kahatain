<?php

namespace App\Http\Requests\V1\Transcripts;

use Illuminate\Foundation\Http\FormRequest;

class GeneralAverageUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'general_average' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
