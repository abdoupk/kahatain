<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;

class CommitteeForceDeleteController extends Controller
{
    public function __invoke(Committee $committee)
    {
        $committee->forceDelete();

        return redirect()->back();
    }
}
