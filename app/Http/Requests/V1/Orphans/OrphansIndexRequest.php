<?php

namespace App\Http\Requests\V1\Orphans;

use Illuminate\Foundation\Http\FormRequest;

class OrphansIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'directions.*' => ['in:asc,desc'],
            'perPage' => ['integer', 'min:10', 'in:10,25,35,50'],
            'page' => ['integer', 'min:1'],
            'search' => ['string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
