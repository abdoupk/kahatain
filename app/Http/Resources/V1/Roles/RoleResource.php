<?php

namespace App\Http\Resources\V1\Roles;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Role */
class RoleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'permissions' => $this->permissions->pluck('name')->mapWithKeys(function ($permission) {
                return [$permission => true];
            })->all(),
        ];
    }
}
