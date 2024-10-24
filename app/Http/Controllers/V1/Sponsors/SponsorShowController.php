<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Sponsors\SponsorShowResource;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class SponsorShowController extends Controller implements HasMiddleware
{
    public function __invoke(Sponsor $sponsor): Response
    {
        return Inertia::render(
            'Tenant/sponsors/details/SponsorDetailPage',
            [
                'sponsor' => new SponsorShowResource(
                    $sponsor->load(
                        'sponsorships',
                        'academicLevel',
                        'family.zone',
                        'family.branch',
                        'incomes',
                        'creator'
                    )->loadCount('orphans')
                ),
            ]
        );
    }

    public static function middleware()
    {
        return ['can:view_sponsors'];
    }
}
