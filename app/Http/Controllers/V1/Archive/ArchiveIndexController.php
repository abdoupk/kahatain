<?php

namespace App\Http\Controllers\V1\Archive;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Archive\ArchiveIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class ArchiveIndexController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:list_archive'];
    }

    public function __invoke(): Response
    {
        return Inertia::render('Tenant/archive/index/ArchiveIndexPage', [
            'items' => ArchiveIndexResource::collection(getArchives()),
            'params' => getParams(),
        ]);
    }
}
