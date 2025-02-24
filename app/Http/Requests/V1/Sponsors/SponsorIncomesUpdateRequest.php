<?php

namespace App\Http\Requests\V1\Sponsors;

use Illuminate\Foundation\Http\FormRequest;

class SponsorIncomesUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'spouse.income' => 'sometimes|nullable|numeric',
            'incomes.cnr' => 'nullable|boolean',
            'incomes.cnas' => 'nullable|boolean',
            'incomes.casnos' => 'nullable|boolean',
            'incomes.pension' => 'nullable|boolean',
            'incomes.other_income' => 'nullable|numeric',
            'incomes.bank_file' => 'nullable|string',
            'incomes.ccp_file' => 'nullable|string',
            'incomes.cnr_file' => 'nullable|string',
            'incomes.cnas_file' => 'nullable|string',
            'incomes.casnos_file' => 'nullable|string',
            'incomes.account.*.*' => 'nullable|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(array_map(fn ($value) => $value ?? false, $this->all()));
    }
}
