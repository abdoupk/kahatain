<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Routing\Controllers\HasMiddleware;

class CommitteeDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(Committee $committee)
    {
        $committee->delete();

        //        dispatch(new ZoneTrashedJob($zone, auth()->user()));

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:delete_committees'];
    }
}
