<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Committees\CommitteeUpdateRequest;
use App\Jobs\V1\Committee\CommitteeUpdatedJob;
use App\Models\Committee;
use Illuminate\Routing\Controllers\HasMiddleware;

class CommitteeUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_committees'];
    }

    public function __invoke(CommitteeUpdateRequest $request, Committee $committee)
    {
        $committee->update($request->validated());

        dispatch(new CommitteeUpdatedJob($committee, auth()->user()));

        return response('', 201);
    }
}
