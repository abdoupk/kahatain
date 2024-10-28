<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Zone\ZoneTrashedJob;
use App\Models\Zone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class ZoneDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_zones'];
    }

    public function __invoke(Zone $zone): RedirectResponse
    {
        $zone->delete();

        dispatch(new ZoneTrashedJob($zone, auth()->user()));

        return redirect()->back();
    }
}
