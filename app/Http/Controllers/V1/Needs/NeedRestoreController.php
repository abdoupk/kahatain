<?php

namespace App\Http\Controllers\V1\Needs;

use App\Http\Controllers\Controller;
use App\Models\Need;
use Illuminate\Routing\Controllers\HasMiddleware;

class NeedRestoreController extends Controller implements HasMiddleware
{
    public function __invoke(Need $need)
    {
        $need->restore();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:restore_trash'];
    }
}
