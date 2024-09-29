<?php

namespace App\Http\Resources\V1\Roles;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Role */
class RolesIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'permissions_count' => $this->permissions_count,
            'users_count' => $this->users_count,
            'created_at' => $this->created_at->format('Y/m/d'),
        ];
    }
}
