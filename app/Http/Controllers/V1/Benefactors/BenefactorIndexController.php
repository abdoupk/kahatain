<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Benefactors\BenefactorsIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class BenefactorIndexController extends Controller implements HasMiddleware
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/benefactors/index/BenefactorsIndexPage', [
            'benefactors' => BenefactorsIndexResource::collection(getBenefactors()),
            'params' => getParams(),
        ]);
    }

    public static function middleware(): array
    {
        return ['can:list_benefactors'];
    }
}
