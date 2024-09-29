<?php

namespace App\Http\Requests\V1\Sponsors;

use Illuminate\Foundation\Http\FormRequest;

class SponsorSponsorshipsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'literacy_lessons' => 'required',
            'medical_sponsorship' => 'required',
            'direct_sponsorship' => 'required',
            'project_support' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
