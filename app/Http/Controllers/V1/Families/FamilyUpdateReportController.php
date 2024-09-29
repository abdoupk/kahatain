<?php

namespace App\Http\Controllers\V1\Families;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Families\FamilyReportUpdateRequest;
use App\Jobs\V1\Family\FamilyUpdatedJob;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;

class FamilyUpdateReportController extends Controller implements HasMiddleware
{
    public function __invoke(FamilyReportUpdateRequest $request, Family $family)
    {
        $family->preview()->update($request->except('inspectors'));

        $family->preview->inspectors()->sync($request->input('inspectors'));

        dispatch(new FamilyUpdatedJob($family, auth()->user()));

        return response('', 201);
    }

    public static function middleware()
    {
        return ['can:update_families'];
    }
}
