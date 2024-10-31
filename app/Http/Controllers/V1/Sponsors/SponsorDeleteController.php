<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Sponsor\SponsorTrashedJob;
use App\Models\Sponsor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;

class SponsorDeleteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:delete_sponsors'];
    }

    public function __invoke(Sponsor $sponsor): RedirectResponse
    {
        $sponsor->deleteWithRelations();

        dispatch(new SponsorTrashedJob($sponsor, auth()->user()));

        return redirect()->back();
    }
}
