<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Committees\CommitteeUpdateRequest;
use App\Models\Committee;

class CommitteeUpdateController extends Controller
{
    public function __invoke(CommitteeUpdateRequest $request, Committee $committee)
    {
        $committee->update($request->validated());

        //        dispatch(new ZoneUpdatedJob($zone, auth()->user()));

        return response('', 201);
    }
}
