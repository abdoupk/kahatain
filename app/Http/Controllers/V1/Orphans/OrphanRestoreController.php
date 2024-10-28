<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use Illuminate\Routing\Controllers\HasMiddleware;

class OrphanRestoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:restore_trash'];
    }

    public function __invoke(Orphan $orphan)
    {
        $orphan->restoreWithRelations();

        return redirect()->back();
    }
}
