<?php

namespace App\Http\Controllers\V1\Branches;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Branch\BranchTrashedJob;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class BranchDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(Branch $branch): RedirectResponse
    {
        $branch->delete();

        dispatch(new BranchTrashedJob($branch, auth()->user()));

        return redirect()->back();
    }

    public static function middleware()
    {
        return [
            'can:delete_branches',
        ];
    }
}
