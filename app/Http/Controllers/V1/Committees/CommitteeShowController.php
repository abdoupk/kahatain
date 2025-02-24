<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class CommitteeShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_committees'];
    }

    public function __invoke(Committee $committee): JsonResponse
    {
        return response()->json([
            'committee' => $committee,
        ]);
    }
}
