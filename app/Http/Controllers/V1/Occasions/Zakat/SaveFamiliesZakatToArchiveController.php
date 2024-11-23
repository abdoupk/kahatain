<?php

namespace App\Http\Controllers\V1\Occasions\Zakat;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\FamilyZakat;
use Illuminate\Http\Request;
use Str;

class SaveFamiliesZakatToArchiveController extends Controller
{
    public function __invoke(Request $request)
    {
        $amount = $request->amount / count($request->families);

        $families = Family::whereIn('id', $request->families);

        $data = $families->get()->map(function (Family $family) use ($request, $amount) {
            return [
                'id' => Str::uuid(),
                'family_id' => $family->id,
                'amount' => $amount,
                'zakat_id' => $request->zakat_id,
                'tenant_id' => $family->tenant_id,
            ];
        });

        FamilyZakat::insert($data->toArray());

        Family::incrementEach([
            'aggregate_zakat_benefit' => $amount,
        ]);
    }
}
