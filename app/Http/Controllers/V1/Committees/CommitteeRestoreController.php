<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use Illuminate\Routing\Controllers\HasMiddleware;

class CommitteeRestoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:restore_trash'];
    }

    public function __invoke(Committee $committee)
    {
        $committee->restore();

        return redirect()->back();
    }
}
