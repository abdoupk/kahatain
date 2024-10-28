<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;

class SponsorRestoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:restore_trash'];
    }

    public function __invoke(Sponsor $sponsor)
    {
        $sponsor->restoreWithRelations();

        return redirect()->back();
    }
}
