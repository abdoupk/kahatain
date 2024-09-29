<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Sponsors\SponsorsIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class SponsorsIndexController extends Controller implements HasMiddleware
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/sponsors/index/SponsorsIndexPage', [
            'sponsors' => SponsorsIndexResource::collection(getSponsors()),
            'params' => getParams(),
        ]);
    }

    public static function middleware()
    {
        return ['can:list_sponsors'];
    }
}
