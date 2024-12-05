<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Family\FamilyTrashedJob;
use App\Models\Family;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Throwable;

class FamilyDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_families'];
    }

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request, Family $family)
    {
        $family->unsearchable();

        $family->delete();

        ray($request->all());

        dispatch(new FamilyTrashedJob($family, auth()->user(), $request->reason));

        return redirect()->back();
    }
}
