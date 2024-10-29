<?php

namespace App\Http\Controllers\V1\Benefactors;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Benefactors\BenefactorUpdateRequest;
use App\Models\Benefactor;
use App\Models\Family;
use App\Models\Orphan;
use App\Models\Sponsorship;

class BenefactorUpdateController extends Controller
{
    public function __invoke(BenefactorUpdateRequest $request, Benefactor $benefactor)
    {
        $benefactor->update($request->except(['sponsorships', 'id']));

        $currentSponsorshipIds = $benefactor->sponsorships->pluck('id')->toArray();
        $newSponsorshipIds = collect($request->sponsorships)->pluck('id')->toArray();

        $toDelete = array_diff($currentSponsorshipIds, $newSponsorshipIds);

        if (empty($toDelete)) {
            return response('', 204);
        }

        $sponsorships = Sponsorship::with('recipientable')->whereIn('id', $toDelete);

        $families = $sponsorships->get()->flatMap(function (Sponsorship $sponsorship) {
            return $sponsorship->recipientable_type === 'orphan'
                ? optional(Orphan::find($sponsorship->recipientable_id))->family
                : Family::find($sponsorship->recipientable_id);
        })->filter()->unique();

        $sponsorshipToDelete = $benefactor->sponsorships()->whereIn('id', $toDelete);

        $sponsorshipToDelete->unsearchable();

        $sponsorshipToDelete->delete();

        $benefactor->searchable();

        foreach ($families as $family) {
            monthlySponsorship($family);
        }

        return response('', 201);
    }
}
