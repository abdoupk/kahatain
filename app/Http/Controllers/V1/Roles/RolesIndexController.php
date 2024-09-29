<?php

namespace App\Http\Controllers\V1\Roles;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Roles\RolesIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class RolesIndexController extends Controller implements HasMiddleware
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/roles/index/RolesIndexPage', [
            'roles' => RolesIndexResource::collection(getRoles()),
            'params' => getParams(),
        ]);
    }

    public static function middleware(): array
    {
        return [
            'can:list_roles',
        ];
    }
}
