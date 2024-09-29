<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\FamilySponsorShipsUpdateRequest;
use App\Jobs\V1\Family\FamilyUpdatedJob;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;

class FamilyUpdateSponsorShipsController extends Controller implements HasMiddleware
{
    public function __invoke(FamilySponsorShipsUpdateRequest $request, Family $family)
    {
        $family->sponsorships()->update($request->validated());

        dispatch(new FamilyUpdatedJob($family, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:update_families'];
    }
}
