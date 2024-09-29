<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Branches\BranchUpdateResource;
use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchShowController extends Controller implements HasMiddleware
{
    public function __invoke(Branch $branch): JsonResponse
    {
        return response()->json([
            'branch' => BranchUpdateResource::make($branch->load(['city', 'president'])),
        ]);
    }

    public static function middleware()
    {
        return [
            'can:update_branches',
        ];
    }
}
