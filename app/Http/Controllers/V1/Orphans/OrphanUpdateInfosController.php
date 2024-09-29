<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Orphans\OrphanInfosUpdateRequest;
use App\Jobs\V1\Orphan\OrphanUpdatedJob;
use App\Models\Orphan;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class OrphanUpdateInfosController extends Controller implements HasMiddleware
{
    public function __invoke(OrphanInfosUpdateRequest $request, Orphan $orphan): ResponseFactory|Application|Response
    {
        $orphan->update($request->except(['baby_milk_quantity', 'baby_milk_type', 'diapers_quantity', 'diapers_type']));

        if (now()->diff($orphan->birth_date)->y < 2) {
            $orphan->babyNeeds()->update($request->only(
                ['baby_milk_quantity',
                    'baby_milk_type',
                    'diapers_quantity',
                    'diapers_type',
                ]
            ));
        }

        dispatch(new OrphanUpdatedJob($orphan, auth()->user()));

        return response('', 201);
    }
    public static function middleware()
    {
        return ['can:update_orphans'];
    }
}
