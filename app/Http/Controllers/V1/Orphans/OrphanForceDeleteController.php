<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use Illuminate\Routing\Controllers\HasMiddleware;

class OrphanForceDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:destroy_trash'];
    }

    public function __invoke(Orphan $orphan)
    {
        $orphan->forceDeleteWithRelations();

        return redirect()->back();
    }
}
