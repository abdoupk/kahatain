<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\FamilyInfosUpdateRequest;
use App\Jobs\V1\Family\FamilyUpdatedJob;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;

class FamilyUpdateInfoController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_families'];
    }

    public function __invoke(FamilyInfosUpdateRequest $request, Family $family)
    {
        $family->update($request->except(['residence_certificate_file', 'c']));

        addToMediaCollection($family, $request->validated('residence_certificate_file'), 'residence_files');

        if ($request->zone_id !== $family->zone_id) {
            $family->zone()->searchable();
        }

        dispatch(new FamilyUpdatedJob($family, auth()->user()));

        return response('', 201);
    }
}
