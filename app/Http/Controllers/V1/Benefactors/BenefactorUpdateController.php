<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Benefactors\BenefactorUpdateRequest;
use App\Models\Benefactor;

class BenefactorUpdateController extends Controller
{
    public function __invoke(BenefactorUpdateRequest $request, Benefactor $benefactor
    ) {
        $benefactor->update($request->validated());

        return response('', 201);
    }
}
