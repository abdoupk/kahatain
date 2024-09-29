<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Zones\ZoneResource;
use App\Models\Zone;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListZonesController extends Controller implements HasMiddleware
{
    public function __invoke()
    {
        return response()->json(ZoneResource::collection(Zone::select(['id', 'name'])->get()));
    }

    public static function middleware()
    {
        return ['can:list_zones'];
    }
}
