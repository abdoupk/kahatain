<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Sponsors\SponsorDetailResource;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class SponsorShowController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:view_sponsors'];
    }

    public function __invoke(Sponsor $sponsor): Response
    {
        return Inertia::render(
            'Tenant/sponsors/details/SponsorDetailPage',
            [
                'sponsor' => new SponsorDetailResource(
                    $sponsor->load(
                        'academicLevel',
                        'family.zone',
                        'family.branch',
                        'incomes.media',
                        'creator'
                    )->loadCount('orphans')
                ),
            ]
        );
    }
}
