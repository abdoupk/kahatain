<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Branches\BranchShowResource;
use App\Models\Branch;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchDetailsController extends Controller implements HasMiddleware
{
    public function __invoke(Branch $branch): JsonResponse
    {
        return response()->json([
            'branch' => BranchShowResource::make(
                $branch->load([
                    'city',
                    'president:id,last_name,first_name',
                    'creator:id,first_name,last_name',
                ])
                    ->loadCount('families')
            ),
        ]);
    }

    public static function middleware()
    {
        return [
            'can:view_branches',
        ];
    }
}
