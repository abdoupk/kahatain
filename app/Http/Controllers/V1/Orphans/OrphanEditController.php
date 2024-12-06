<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Orphans\OrphanEditResource;
use App\Models\Orphan;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class OrphanEditController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_orphans'];
    }

    public function __invoke(Orphan $orphan): Response
    {
        ray(new OrphanEditResource($orphan->load(
            'babyNeeds',
            'creator',
            'shoesSize',
            'pantsSize',
            'shirtSize',
            'media',
            'institution'
        )));

        return Inertia::render(
            'Tenant/orphans/edit/OrphanEditPage',
            [
                'orphan' => new OrphanEditResource($orphan->load(
                    'babyNeeds',
                    'creator',
                    'shoesSize',
                    'pantsSize',
                    'shirtSize',
                    'media',
                    'institution'
                )),
            ]
        );
    }
}
