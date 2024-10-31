<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Branches\BranchesIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class BranchesIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:list_branches',
        ];
    }

    public function __invoke(): Response
    {
        return Inertia::render('Tenant/branches/BranchesIndexPage', [
            'branches' => BranchesIndexResource::collection(getBranches()),
            'params' => getParams(),
        ]);
    }
}
