<?php

namespace App\Http\Controllers\V1\Committees;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Committees\CommitteesIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class CommitteesIndexController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'can:list_zones',
        ];
    }

    public function __invoke(): Response
    {
        return Inertia::render('Tenant/committees/index/CommitteesIndexPage', [
            'committees' => CommitteesIndexResource::collection(getCommittees()),
            'params' => getParams(),
        ]);
    }
}
