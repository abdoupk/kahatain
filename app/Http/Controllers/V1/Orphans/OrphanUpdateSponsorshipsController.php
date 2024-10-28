<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Orphans\OrphanSponsorshipsUpdateRequest;
use App\Jobs\V1\Orphan\OrphanUpdatedJob;
use App\Models\Orphan;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class OrphanUpdateSponsorshipsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_orphans'];
    }

    public function __invoke(OrphanSponsorshipsUpdateRequest $request, Orphan $orphan): Response
    {
        $orphan->sponsorships()->update($request->validated());

        dispatch(new OrphanUpdatedJob($orphan, auth()->user()));

        return response('', 201);
    }
}
