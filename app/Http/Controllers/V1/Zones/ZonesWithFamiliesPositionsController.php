<?php

namespace App\Http\Controllers\V1\Zones;

use App\Http\Controllers\Controller;
use App\Models\Zone;

class ZonesWithFamiliesPositionsController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'zones' => Zone::with(['families' => function ($q): void {
                $q->select(['zone_id', 'location', 'name', 'address']);
            }])->select(['id', 'name', 'geom'])->get(),
        ]);
    }
}
