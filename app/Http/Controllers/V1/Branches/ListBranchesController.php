<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Branches\BranchesResource;
use App\Models\Branch;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListBranchesController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_branches'];
    }

    public function __invoke()
    {
        return response()->json(BranchesResource::collection(Branch::select(['id', 'name'])->get()));
    }
}
