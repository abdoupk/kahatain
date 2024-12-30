<?php

namespace App\Http\Controllers\V1\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MonthlySponsorship\UpdateMonthlySponsorshipSettingsRequest;
use App\Jobs\V1\SiteSettings\MonthlySponsorshipSettingsUpdatedJob;
use Illuminate\Routing\Controllers\HasMiddleware;

class UpdateMonthlySponsorshipSettingsController extends Controller implements HasMiddleware
{
    public function __invoke(UpdateMonthlySponsorshipSettingsRequest $request)
    {
        $data = json_decode(auth()->user()->tenant->calculation, true);

        $data['monthly_sponsorship'] = array_replace($data['monthly_sponsorship'], $request->all());

        auth()->user()->tenant->update(['calculation' => json_encode($data)]);

        dispatch(new MonthlySponsorshipSettingsUpdatedJob(auth()->user()));

        return response('', 204);
    }

    public static function middleware()
    {
        return ['can:update_settings_monthly_sponsorships'];
    }
}
