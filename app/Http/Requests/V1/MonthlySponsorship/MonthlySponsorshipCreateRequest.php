<?php

namespace App\Http\Requests\V1\MonthlySponsorship;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MonthlySponsorshipCreateRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'benefactor.id' => __('the_benefactor'),
            'sponsorship_type' => __('sponsorship_type'),
        ];
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer'],
            'benefactor.id' => ['required', 'uuid', 'exists:benefactors,id'],
            'recipientable_id' => ['required', 'uuid'],
            'recipientable_type' => ['required', 'string'],
            'sponsorship_type' => ['required', 'string', Rule::in(['monthly_basket', 'ccp', 'cash'])],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
