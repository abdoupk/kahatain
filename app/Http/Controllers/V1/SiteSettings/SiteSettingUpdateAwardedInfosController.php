<?php

namespace App\Http\Controllers\V1\SiteSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SiteSettings\UpdateSiteAwardedInfosRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class SiteSettingUpdateAwardedInfosController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_settings'];
    }

    public function __invoke(UpdateSiteAwardedInfosRequest $request)
    {
        $data = json_decode(auth()->user()->tenant->calculation);

        $data->unemployment_benefit = $request->unemployment_benefit;
        $data->university_scholarship = $request->university_scholarship;
        $data->threshold = $request->threshold;

        auth()->user()->tenant->update([
            'calculation' => json_encode($data),
        ]);

        return response('', 204);
    }
}
