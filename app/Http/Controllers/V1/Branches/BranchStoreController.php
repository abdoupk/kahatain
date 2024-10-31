<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Branches\BranchCreateUpdateRequest;
use App\Jobs\V1\Branch\BranchCreatedJob;
use App\Models\Branch;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchStoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:create_branches',
        ];
    }

    public function __invoke(BranchCreateUpdateRequest $request): Response
    {
        $branch = Branch::create($request->validated());

        dispatch(new BranchCreatedJob($branch, auth()->user()));

        return response('', 201);
    }
}
