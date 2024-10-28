<?php

namespace App\Http\Controllers\V1\Needs;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Needs\NeedUpdateRequest;
use App\Jobs\V1\Need\NeedUpdatedJob;
use App\Models\Need;
use Illuminate\Routing\Controllers\HasMiddleware;

class NeedUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_needs'];
    }

    public function __invoke(NeedUpdateRequest $request, Need $need)
    {
        $need->update($request->only(['status', 'subject', 'demand', 'note']));

        dispatch(new NeedUpdatedJob($need, auth()->user()));

        return response('', 201);
    }
}
