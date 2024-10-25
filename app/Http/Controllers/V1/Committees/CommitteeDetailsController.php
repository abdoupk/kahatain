<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Committees\CommitteeShowResource;
use App\Models\Committee;
use Illuminate\Http\JsonResponse;

class CommitteeDetailsController extends Controller
{
    public function __invoke(Committee $committee): JsonResponse
    {
        return response()->json([
            'committee' => CommitteeShowResource::make($committee->load(
                ['creator:id,first_name,last_name']
            )->loadCount(['members'])),
        ]);
    }
}
