<?php

namespace App\Http\Middleware;

use Arr;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $this->getAuthData(),
                'settings' => auth()->user()?->settings,
            ],
            'association' => tenant('infos')['association'] ?? null,
            'language' => auth()->user()?->settings?->locale ?? null,
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }

    protected function getAuthData(): ?array
    {
        if (auth()->user()) {
            return Arr::map(
                auth()
                    ->user()
                    ->load(['roles'])
                    ->only(['roles', 'id', 'first_name', 'gender', 'last_name', 'tenant_id']),
                function ($value, $key) {
                    if ($key === 'roles') {
                        return $value->pluck('name')->toArray();
                    }

                    return $value;
                }
            ) +
                [
                    'permissions' => auth()->user()
                        ->getPermissionsViaRoles()
                        ->pluck('name')
                        ->toArray(),
                ];
        }

        return null;
    }
}
