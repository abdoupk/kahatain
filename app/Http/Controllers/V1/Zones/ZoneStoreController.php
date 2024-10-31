<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Zones\ZoneCreateRequest;
use App\Jobs\V1\Zone\ZoneCreatedJob;
use App\Models\Zone;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ZoneStoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:create_zones'];
    }

    public function __invoke(ZoneCreateRequest $request): Response
    {
        $geometry = $request->geom['geometry'];

        //        $geom = DB::raw("ST_SetSRID(ST_GeomFromGeoJSON('".json_encode($geometry)."'), 4326)");

        $zone = Zone::create([
            ...$request->validated(),
        ]);

        dispatch(new ZoneCreatedJob($zone, auth()->user()));

        return response('', 201);
    }
}
