<?php

namespace App\Http\Requests\V1\Needs;

use App\Enums\NeedStatus;
use Illuminate\Foundation\Http\FormRequest;

class NeedUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'demand' => 'required|string',
            'subject' => 'required|string',
            'note' => 'nullable|string',
            'status' => 'required|in:'.implode(',', array_map(fn ($case) => $case->value, NeedStatus::cases())),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
