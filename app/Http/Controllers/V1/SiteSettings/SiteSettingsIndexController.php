<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SiteSetting\SiteSettingsIndexResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;
use Inertia\Response;

class SiteSettingsIndexController extends Controller implements HasMiddleware
{
    public function __invoke(): Response
    {
        return Inertia::render('Tenant/settings/SettingsIndexPage', [
            'settings' => SiteSettingsIndexResource::make(auth()->user()->tenant),
            'calculation' => json_decode(auth()->user()->tenant->calculation),
        ]);
    }

    public static function middleware()
    {
        return ['can:view_settings'];
    }
}
