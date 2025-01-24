<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MonthlySponsorship\MonthlySponsorshipCreateRequest;
use App\Jobs\V1\Benefactor\BenefactorSponsorshipCreatedJob;
use App\Models\Benefactor;
use App\Models\Sponsorship;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorSponsorshipStoreController extends Controller implements HasMiddleware
{
    public function __invoke(MonthlySponsorshipCreateRequest $request)
    {
        $sponsorship = Sponsorship::create([
            ...$request->except('benefactor', 'shop'),
            'benefactor_id' => $request->validated('benefactor.id'),
            'shop' => $request->sponsorship_type === 'monthly_basket' ? $request->validated('shop') : null,
        ]);

        $benefactor = Benefactor::whereId($request->validated('benefactor.id'));

        $benefactor->searchable();

        dispatch(new BenefactorSponsorshipCreatedJob($benefactor->first(), $sponsorship, auth()->user()));

        return response('', 204);
    }

    public static function middleware()
    {
        return ['can:add_new_sponsorship_benefactors'];
    }
}
