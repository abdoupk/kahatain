<?php

namespace App\Http\Controllers\V1\API\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use Cache;
use Illuminate\Http\JsonResponse;

class WilayaController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'wilayas' => Cache::rememberForever('wilayas', function () {
                City::select([
                    'wilaya_code',
                    'wilaya_name',
                ])->orderBy('wilaya_code')
                    ->groupBy(['wilaya_code', 'wilaya_name'])
                    ->get();
            }),
        ]);
    }
}
