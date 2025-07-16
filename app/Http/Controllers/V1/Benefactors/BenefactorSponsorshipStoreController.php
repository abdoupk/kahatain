<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MonthlySponsorship\MonthlySponsorshipCreateRequest;
use App\Jobs\V1\Benefactor\BenefactorSponsorshipCreatedJob;
use App\Models\Benefactor;
use App\Models\Family;
use App\Models\Orphan;
use App\Models\Sponsorship;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorSponsorshipStoreController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return ['can:add_new_sponsorship_benefactors'];
    }

    public function __invoke(MonthlySponsorshipCreateRequest $request)
    {
        $sponsorship = Sponsorship::create([
            ...$request->except('benefactor', 'shop'),
            'benefactor_id' => $request->validated('benefactor'),
            'shop' => $request->sponsorship_type === 'monthly_basket' ? $request->validated('shop') : null,
        ]);

        $benefactor = Benefactor::whereId($request->validated('benefactor'));

        $benefactor->searchable();

        $family = null;

        if ($request->recipientable_type === 'orphan') {
            $family = Orphan::with('family')->firstWhere('id', $request->recipientable_id)?->family;
        } elseif ($request->recipientable_type === 'family') {
            $family = Family::query()->firstWhere('id', $request->recipientable_id);
        }

        if ($family !== null) {
            monthlySponsorship($family);
        }

        dispatch(new BenefactorSponsorshipCreatedJob($benefactor->first(), $sponsorship, auth()->user()));

        return response('', 204);
    }
}
