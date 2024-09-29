<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Routing\Controllers\HasMiddleware;

class ZoneRestoreController extends Controller implements HasMiddleware
{
    public function __invoke(Zone $zone)
    {
        $zone->restore();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:restore_zones'];
    }
}
