<?php

namespace App\Http\Controllers\V1\API\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DairaController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(City::select([
            'id',
            'wilaya_code',
            'daira_name',
        ])->where(DB::raw('daira_name'), DB::raw('commune_name'))
            ->where('wilaya_code', '=', $request->wilaya_code)
            ->get());
    }
}
