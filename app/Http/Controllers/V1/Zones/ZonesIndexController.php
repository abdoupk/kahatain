<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Zones\ZonesIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class ZonesIndexController extends Controller implements HasMiddleware
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/zones/index/ZonesIndexPage', [
            'zones' => ZonesIndexResource::collection(getZones()),
            'params' => getParams(),
        ]);
    }

    public static function middleware(): array
    {
        return [
            'can:list_zones',
        ];
    }
}
