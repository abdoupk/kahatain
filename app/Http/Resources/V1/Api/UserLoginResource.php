<?php

namespace App\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $email
 * @property string $password
 * @property string $id
 * @property string $tenant_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 *
 * @method createToken(string $string)
 */
class UserLoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $accessToken = $this->createToken('auth_token');

        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'tenant_id' => $this->tenant_id,
            'access_token' => [
                'id' => $accessToken->accessToken->id,
                'token' => $accessToken->plainTextToken,
            ],
        ];
    }
}
