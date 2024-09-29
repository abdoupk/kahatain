<?php

namespace App\Http\Requests\V1\Sponsors;

use Illuminate\Foundation\Http\FormRequest;

class SponsorIncomesUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'account' => 'required',
            'casnos' => 'required',
            'cnas' => 'required',
            'cnr' => 'required',
            'other_income' => 'required',
            'pension' => 'required',
            'total_income' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(array_map(function ($value) {
            return $value === null ? false : $value;
        }, $this->all()));
    }
}
