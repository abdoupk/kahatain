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
    public function __invoke(ZoneCreateRequest $request): Response
    {
        $zone = Zone::create($request->validated());

        dispatch(new ZoneCreatedJob($zone, auth()->user()));

        return response('', 201);
    }
    public static function middleware()
    {
        return ['can:create_zones'];
    }
}
