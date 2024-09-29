<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Families\FamilyEditResource;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class FamilyEditController extends Controller implements HasMiddleware
{
    public function __invoke(Family $family): Response
    {
        return Inertia::render('Tenant/families/edit/FamilyEditPage', [
            'family' => FamilyEditResource::make(
                $family->load(['furnishings',
                    'housing',
                    'sponsor.incomes',
                    'creator:id,last_name,first_name',
                    'sponsor',
                    'secondSponsor',
                    'sponsorships',
                    'preview.inspectors',
                    'deceased',
                ])
            ),
        ]);
    }
    public static function middleware()
    {
        return ['can:update_families'];
    }
}
