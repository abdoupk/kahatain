<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Benefactors\BenefactorUpdateRequest;
use App\Jobs\V1\Benefactor\BenefactorUpdatedJob;
use App\Models\Benefactor;
use App\Models\Family;
use App\Models\Orphan;
use App\Models\Sponsorship;
use Illuminate\Routing\Controllers\HasMiddleware;

class BenefactorUpdateController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_benefactors'];
    }

    public function __invoke(BenefactorUpdateRequest $request, Benefactor $benefactor)
    {
        $benefactor->update($request->except(['sponsorships', 'id']));

        $currentSponsorshipIds = $benefactor->sponsorships->pluck('id')->toArray();
        $newSponsorshipIds = collect($request->sponsorships)->pluck('id')->toArray();

        $toDelete = array_diff($currentSponsorshipIds, $newSponsorshipIds);

        if ($toDelete === []) {
            return response('', 204);
        }

        $sponsorships = Sponsorship::with('recipientable')->whereIn('id', $toDelete);

        $families = $sponsorships->get()->flatMap(fn (Sponsorship $sponsorship) => $sponsorship->recipientable_type === 'orphan'
            ? optional(Orphan::find($sponsorship->recipientable_id))->family
            : Family::find($sponsorship->recipientable_id))->filter()->unique();

        $sponsorshipToDelete = $benefactor->sponsorships()->whereIn('id', $toDelete);

        $sponsorshipToDelete->unsearchable();

        $sponsorshipToDelete->delete();

        $benefactor->searchable();

        foreach ($families as $family) {
            monthlySponsorship($family);
        }

        dispatch(new BenefactorUpdatedJob($benefactor, auth()->user()));

        return response('', 201);
    }
}
