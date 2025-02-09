<?php

namespace App\Http\Controllers\V1\Occasions\EidAlAdha;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\FamilyEidAlAdhaUpdateStatusRequest;
use App\Jobs\V1\Occasion\EidAlAdhaFamiliesStatusUpdatedJob;
use App\Models\Family;
use Illuminate\Routing\Controllers\HasMiddleware;

class EidAlAdhaChangeStatusController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:save_occasions'];
    }

    public function __invoke(FamilyEidAlAdhaUpdateStatusRequest $request, Family $family)
    {
        $family->update([
            'eid_al_adha_status' => $request->status,
        ]);

        $family->eidAlAdhas()->updateOrCreate([
            'year' => now()->year,
        ], [
            'status' => $request->status,
            'year' => now()->year,
            'updated_by' => auth()->id(),
        ]);

        dispatch(new EidAlAdhaFamiliesStatusUpdatedJob($family, $request->validated('status'), auth()->user()));
    }
}
