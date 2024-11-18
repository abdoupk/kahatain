<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\FamilySecondSponsorUpdateRequest;
use App\Jobs\V1\Family\FamilyUpdatedJob;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;

class FamilyUpdateSecondSponsorController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_families'];
    }

    public function __invoke(FamilySecondSponsorUpdateRequest $request, Family $family)
    {
        $family->secondSponsor()->update($request->validated());

        monthlySponsorship($family);

        dispatch(new FamilyUpdatedJob($family, auth()->user()));

        return response('', 201);
    }
}
