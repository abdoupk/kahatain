<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Benefactors\BenefactorsIndexResource;
use Inertia\Inertia;

class BenefactorIndexController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Tenant/benefactors/index/BenefactorsIndexPage', [
            'benefactors' => BenefactorsIndexResource::collection(getBenefactors()),
            'params' => getParams(),
        ]);
    }
}
