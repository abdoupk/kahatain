<?php

namespace App\Http\Requests\V1\Orphans;

use Illuminate\Foundation\Http\FormRequest;

class OrphanSponsorshipsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'association_trips' => 'required|bool',
            'eid_suit' => 'required|bool',
            'medical_sponsorship' => 'required|bool',
            'private_lessons' => 'required|bool',
            'school_bag' => 'required|bool',
            'summer_camp' => 'required|bool',
            'university_scholarship' => 'required|bool',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
