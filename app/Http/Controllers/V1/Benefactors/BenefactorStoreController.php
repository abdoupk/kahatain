<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Benefactors\BenefactorCreateRequest;
use App\Jobs\V1\Benefactor\BenefactorCreatedJob;
use App\Models\Benefactor;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorStoreController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:create_benefactors'];
    }

    public function __invoke(BenefactorCreateRequest $request)
    {
        $benefactor = Benefactor::create($request->validated());

        dispatch(new BenefactorCreatedJob($benefactor, auth()->user()));

        return response('', 201);
    }
}
