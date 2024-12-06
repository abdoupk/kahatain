<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\FamilyFurnishingsUpdateRequest;
use App\Jobs\V1\Family\FamilyUpdatedJob;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;

class FamilyUpdateFurnishingsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_families'];
    }

    public function __invoke(FamilyFurnishingsUpdateRequest $request, Family $family)
    {
        ray($request->validated());
        $family->furnishings()->update($request->validated());

        dispatch(new FamilyUpdatedJob($family, auth()->user()));

        return response('', 201);
    }
}
