<?php

namespace App\Http\Requests\V1\Families;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $perPage
 * @property array $directions
 * @property int $page
 * @property string $search
 */
class FamiliesIndexRequest extends FormRequest
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
