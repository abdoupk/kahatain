<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;

class SponsorForceDeleteController extends Controller implements HasMiddleware
{
    public function __invoke(Sponsor $sponsor)
    {
        $sponsor->forceDeleteWithRelations();

        return redirect()->back();
    }

    public static function middleware()
    {
        return ['can:destroy_trash'];
    }
}
