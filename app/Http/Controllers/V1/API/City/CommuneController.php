<?php

namespace App\Http\Controllers\V1\API\City;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(City::select([
            'id',
            'commune_name',
        ])->where('daira_name', '=', $request->daira_name)
            ->where('wilaya_code', '=', $request->wilaya_code)
            ->get());
    }
}
