<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class FamiliesPositionsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'positions' => getFamiliesPosition(),
        ]);
    }
}
