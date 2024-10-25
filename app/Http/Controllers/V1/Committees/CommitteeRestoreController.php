<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;

class CommitteeRestoreController extends Controller
{
    public function __invoke(Committee $committee)
    {
        $committee->restore();

        return redirect()->back();
    }
}
