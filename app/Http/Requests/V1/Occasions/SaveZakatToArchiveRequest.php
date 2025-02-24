<?php

namespace App\Http\Requests\V1\Occasions;

use Illuminate\Foundation\Http\FormRequest;

class SaveZakatToArchiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'families' => 'required|array|min:1',
            'zakat_id' => 'required|exists:finances,id',
            'amount' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
