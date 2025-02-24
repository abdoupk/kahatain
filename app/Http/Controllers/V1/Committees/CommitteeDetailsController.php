<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Committees\CommitteeShowResource;
use App\Models\Committee;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class CommitteeDetailsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_committees'];
    }

    public function __invoke(Committee $committee): JsonResponse
    {
        return response()->json([
            'committee' => CommitteeShowResource::make($committee->load(
                ['creator:id,first_name,last_name']
            )->loadCount(['members'])),
        ]);
    }
}
