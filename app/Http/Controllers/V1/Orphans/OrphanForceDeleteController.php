<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Models\Orphan;
use Illuminate\Routing\Controllers\HasMiddleware;

class OrphanForceDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(Orphan $orphan)
    {
        $orphan->forceDeleteWithRelations();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:destroy_trash'];
    }
}
