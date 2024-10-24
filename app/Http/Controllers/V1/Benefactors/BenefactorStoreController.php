<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Benefactors\BenefactorCreateRequest;
use App\Models\Benefactor;

class BenefactorStoreController extends Controller
{
    public function __invoke(BenefactorCreateRequest $request)
    {
        Benefactor::create($request->validated());

        return response('', 201);
    }
}
