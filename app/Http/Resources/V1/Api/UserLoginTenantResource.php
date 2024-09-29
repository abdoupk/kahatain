<?php

namespace App\Http\Resources\V1\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $email
 * @property string $association
 * @property string $domain
 * @property string $password
 * @property string $name
 */
class UserLoginTenantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'data' => [
                'super_admin_credentials' => [
                    'email' => $this->email,
                    'name' => $this->name,
                    'password' => $this->password,
                ],
                'association' => $this->association,
                'domain' => $this->domain,
            ],
        ];
    }
}
