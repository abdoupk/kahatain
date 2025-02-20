<?php

namespace App\Http\Middleware;

use App\Models\City;
use Arr;
use Cache;
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
                'settings' => auth()->user()?->load('settings')->settings,
            ],
            'association' => tenant('infos')['association'] ?? null,
            'association_coordinates' => [
                'lat' => $this->getCoordinates()?->latitude ?? null,
                'lng' => $this->getCoordinates()?->longitude ?? null,
            ] ?? null,
            'language' => 'ar',
            'ziggy' => fn () => array_merge((new Ziggy)->toArray(), [
                'location' => $request->url(),
            ]),
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

    private function getCoordinates(): ?City
    {
        $city_id = tenant()['infos']['city_id'] ?? null;

        if (! $city_id) {
            return null;
        }

        return Cache::rememberForever(
            'city-coordinates-'.$city_id,
            fn () => City::whereId($city_id)
                ->select(['latitude', 'longitude'])
                ->first());
    }
}
