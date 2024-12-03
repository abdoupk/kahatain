<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Orphans\OrphanShowResource;
use App\Models\Orphan;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class OrphanShowController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'can:view_orphans',
        ];
    }

    public function __invoke(Orphan $orphan): Response
    {
        return Inertia::render('Tenant/orphans/details/OrphanDetailPage', [
            'orphan' => new OrphanShowResource(
                $orphan->load(
                    'babyNeeds.diapers',
                    'babyNeeds.babyMilk',
                    'creator',
                )
            ),
        ]);
    }
}
