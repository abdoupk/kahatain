<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchRestoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'can:restore_trash',
        ];
    }

    public function __invoke(Branch $branch)
    {
        $branch->restore();

        return redirect()->back();
    }
}
