<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\FamilyHousingUpdateRequest;
use App\Jobs\V1\Family\FamilyUpdatedJob;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;

class FamilyUpdateHousingController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_families'];
    }

    public function __invoke(FamilyHousingUpdateRequest $request, Family $family)
    {
        $family->housing()->update([
            ...$request->except('housing_type'),
            'name' => $request->input('housing_type.name'),
            'value' => $request->input('housing_type.value'),
        ]);

        dispatch(new FamilyUpdatedJob($family, auth()->user()));

        return response('', 201);
    }
}
