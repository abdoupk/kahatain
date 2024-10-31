<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Families\FamiliesIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class FamiliesIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_families'];
    }

    public function __invoke(): Response
    {
        return Inertia::render('Tenant/families/index/FamiliesIndexPage', [
            'families' => FamiliesIndexResource::collection(getFamilies()),
            'params' => getParams(),
        ]);
    }
}
