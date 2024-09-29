<?php

namespace App\Http\Controllers\V1\Needs;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Needs\NeedCreateRequest;
use App\Jobs\V1\Need\NeedCreatedJob;
use App\Models\Need;
use Illuminate\Routing\Controllers\HasMiddleware;

class NeedStoreController extends Controller implements HasMiddleware
{
    public function __invoke(NeedCreateRequest $request)
    {
        $need = Need::create($request->validated());

        dispatch(new NeedCreatedJob($need, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:create_needs'];
    }
}
