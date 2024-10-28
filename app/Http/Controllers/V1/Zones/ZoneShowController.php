<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class ZoneShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_zones'];
    }

    public function __invoke(Zone $zone): JsonResponse
    {
        return response()->json([
            'zone' => $zone,
        ]);
    }
}
