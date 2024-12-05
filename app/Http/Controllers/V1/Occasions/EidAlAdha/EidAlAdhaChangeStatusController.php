<?php

namespace App\Http\Controllers\V1\Occasions\EidAlAdha;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\FamilyEidAlAdhaUpdateStatusRequest;
use App\Models\Family;

class EidAlAdhaChangeStatusController extends Controller
{
    public function __invoke(FamilyEidAlAdhaUpdateStatusRequest $request, Family $family)
    {
        $family->eidAlAdhas()->updateOrCreate([
            'year' => now()->year,
        ], [
            'status' => $request->status,
            'year' => now()->year,
            'updated_by' => auth()->id(),
        ]);
    }
}
