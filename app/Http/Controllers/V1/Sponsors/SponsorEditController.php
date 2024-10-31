<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Sponsors\SponsorEditResource;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class SponsorEditController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_sponsors'];
    }

    public function __invoke(Sponsor $sponsor)
    {
        return Inertia::render('Tenant/sponsors/edit/SponsorEditPage', [
            'sponsor' => new SponsorEditResource($sponsor->load('creator', 'sponsorships', 'incomes', 'academicLevel')),
        ]);
    }
}
