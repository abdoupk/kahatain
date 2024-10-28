<?php

namespace App\Http\Controllers\V1\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Roles\RoleCreateRequest;
use App\Jobs\V1\Role\RoleCreatedJob;
use App\Models\Role;
use DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Throwable;

class RoleStoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:create_roles'];
    }

    /**
     * @throws Throwable
     */
    public function __invoke(RoleCreateRequest $request)
    {
        DB::transaction(function () use ($request): void {
            $role = Role::create($request->only('name'));

            $permissions = array_keys(array_filter($request->permissions));

            $role->givePermissionTo($permissions);

            dispatch(new RoleCreatedJob($role, auth()->user()));
        });

        return response('', 201);
    }
}
