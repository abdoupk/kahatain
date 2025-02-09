<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Routing\Controllers\HasMiddleware;

class CommitteeForceDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:destroy_trash'];
    }

    public function __invoke(Committee $committee)
    {
        $committee->forceDelete();

        return redirect()->back();
    }
}
