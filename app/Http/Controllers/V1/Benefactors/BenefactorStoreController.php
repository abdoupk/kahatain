<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Benefactors\BenefactorCreateRequest;
use App\Models\Benefactor;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorStoreController extends Controller implements HasMiddleware
{
    public function __invoke(BenefactorCreateRequest $request)
    {
        Benefactor::create($request->validated());

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:create_benefactors'];
    }
}
