<?php

namespace App\Http\Requests\V1;

use App\Rules\RegistrationDomainRequiredRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

/**
 * @property string $domain
 */
class RegisterTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'association' => 'required|string|max:255',
            'domain' => [new RegistrationDomainRequiredRule, 'string', 'max:255'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'domain' => Str::domain($this->domain),
        ]);
    }
}
