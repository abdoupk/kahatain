<?php

namespace App\Http\Controllers\V1\Orphans;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Orphans\OrphanStoreRequest;
use App\Models\Family;
use App\Models\Orphan;

class OrphanStoreController extends Controller
{
    public function __invoke(OrphanStoreRequest $request)
    {
        $sponsor = Family::find($request->family_id)->sponsor;

        $orphan = Orphan::create([
            ...$request->except(['baby_milk_quantity', 'baby_milk_type', 'diapers_quantity', 'diapers_type', 'vocational_training_id']),
            'sponsor_id' => $sponsor->id,
        ]);

        if (now()->diff($orphan->birth_date)->y < 2) {
            $orphan->babyNeeds()->create([
                ...$request->only(
                    'baby_milk_quantity',
                    'baby_milk_type',
                    'diapers_quantity',
                    'diapers_type',
                ),
                'family_id' => $orphan->family_id,
            ]);
        }

        return response()->noContent();
    }
}
