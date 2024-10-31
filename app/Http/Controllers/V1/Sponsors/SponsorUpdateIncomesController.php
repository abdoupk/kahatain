<?php

namespace App\Http\Controllers\V1\Sponsors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sponsors\SponsorIncomesUpdateRequest;
use App\Jobs\V1\Sponsor\SponsorUpdatedJob;
use App\Models\Sponsor;
use Illuminate\Routing\Controllers\HasMiddleware;

class SponsorUpdateIncomesController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_sponsors'];
    }

    public function __invoke(SponsorIncomesUpdateRequest $request, Sponsor $sponsor)
    {
        $sponsor->incomes()->update([
            ...$request->except('total_income'),
            'total_income' => array_sum($request->except('total_income')),
        ]);

        monthlySponsorship($sponsor->load('family')->family);

        dispatch(new SponsorUpdatedJob($sponsor, auth()->user()));

        return response('', 201);
    }
}
