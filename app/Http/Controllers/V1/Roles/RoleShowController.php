<?php

namespace App\Http\Controllers\V1\Roles;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Roles\RoleResource;
use App\Models\Role;

class RoleShowController extends Controller
{
    public function __invoke(Role $role)
    {
        return response()->json([
            'role' => RoleResource::make($role->load(['permissions'])),
        ]);
    }
}
