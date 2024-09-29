<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeamsPermissionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! empty(auth()->user())) {
            setPermissionsTeamId(tenant('id'));
        }

        return $next($request);
    }
}
