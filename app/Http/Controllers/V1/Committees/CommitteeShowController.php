<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Http\JsonResponse;

class CommitteeShowController extends Controller
{
    public function __invoke(Committee $committee): JsonResponse
    {
        return response()->json([
            'committee' => $committee,
        ]);
    }
}
