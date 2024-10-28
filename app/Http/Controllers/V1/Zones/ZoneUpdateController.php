<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Zones\ZoneUpdateRequest;
use App\Jobs\V1\Zone\ZoneUpdatedJob;
use App\Models\Zone;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class ZoneUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_zones'];
    }

    public function __invoke(ZoneUpdateRequest $request, Zone $zone): Response
    {
        $zone->update($request->validated());

        dispatch(new ZoneUpdatedJob($zone, auth()->user()));

        return response('', 201);
    }
}
