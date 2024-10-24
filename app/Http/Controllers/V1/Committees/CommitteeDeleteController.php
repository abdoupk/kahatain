<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;

class CommitteeDeleteController extends Controller
{
    public function __invoke(Committee $committee)
    {
        $committee->delete();

        //        dispatch(new ZoneTrashedJob($zone, auth()->user()));

        return redirect()->back();
    }
}
