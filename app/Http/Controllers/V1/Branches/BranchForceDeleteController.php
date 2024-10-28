<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchForceDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:destroy_trash',
        ];
    }

    public function __invoke(Branch $branch)
    {
        $branch->forceDelete();

        return response('', 204);
    }
}
