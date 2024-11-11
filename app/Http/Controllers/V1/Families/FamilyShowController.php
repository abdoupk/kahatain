<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Families\FamilyShowResource;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class FamilyShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_families'];
    }

    public function __invoke(Family $family): Response
    {
        return Inertia::render(
            'Tenant/families/details/FamilyDetailPage',
            [
                'family' => FamilyShowResource::make($family->load(
                    [
                        'zone',
                        'orphans.academicLevel',
                        'orphans.shoesSize',
                        'orphans.pantsSize',
                        'orphans.babyNeeds.babyMilk',
                        'orphans.babyNeeds.diapers',
                        'orphans.shirtSize',
                        'furnishings',
                        'housing',
                        'sponsor.incomes',
                        'sponsor.creator',
                        'secondSponsor',
                        'furnishings',
                        'branch',
                        'preview.inspectors',
                        'deceased',
                    ]
                )),
            ]
        );
    }
}
