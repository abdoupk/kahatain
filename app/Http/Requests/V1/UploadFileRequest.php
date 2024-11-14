<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'filepond' => __('the_file'),
        ];
    }

    public function rules(): array
    {
        return [
            'filepond' => 'required|file|max:10240',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
