<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Committees\CommitteeCreateRequest;
use App\Models\Committee;

class CommitteeStoreController extends Controller
{
    public function __invoke(CommitteeCreateRequest $request)
    {
        Committee::create($request->validated());

        //        dispatch(new ZoneCreatedJob($zone, auth()->user()));

        return response('', 201);
    }
}
