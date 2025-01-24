<?php

namespace App\Http\Controllers\V1\Occasions\EidSuit;

use App\Http\Controllers\Controller;
use App\Jobs\V1\Occasion\EidSuitOrphansResetInfosJob;
use App\Models\OrphanEidSuit;

class ResetEidSuitInfosController extends Controller
{
    public function __invoke()
    {
        OrphanEidSuit::truncate();

        dispatch(new EidSuitOrphansResetInfosJob(auth()->user()));
    }
}
