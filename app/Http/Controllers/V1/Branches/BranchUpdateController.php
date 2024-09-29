<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Branches\BranchCreateUpdateRequest;
use App\Jobs\V1\Branch\BranchUpdatedJob;
use App\Models\Branch;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchUpdateController extends Controller implements HasMiddleware
{
    public function __invoke(
        BranchCreateUpdateRequest $request,
        Branch $branch
    ): Response {
        $branch->update($request->validated());

        dispatch(new BranchUpdatedJob($branch, auth()->user()));

        return response('', 201);
    }
    public static function middleware()
    {
        return ['can:update_branches'];
    }
}
