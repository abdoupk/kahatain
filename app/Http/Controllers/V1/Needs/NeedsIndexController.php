<?php

namespace App\Http\Controllers\V1\Needs;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Needs\NeedsIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class NeedsIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_needs'];
    }

    public function __invoke(): Response
    {
        return Inertia::render('Tenant/needs/index/NeedsIndexPage', [
            'needs' => NeedsIndexResource::collection(getNeeds()),
            'params' => getParams(),
        ]);
    }
}
