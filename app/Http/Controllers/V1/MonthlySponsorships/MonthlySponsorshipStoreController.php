<?php

namespace App\Http\Controllers\V1\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MonthlySponsorship\MonthlySponsorshipCreateRequest;
use App\Models\Benefactor;
use App\Models\Sponsorship;

class MonthlySponsorshipStoreController extends Controller
{
    public function __invoke(MonthlySponsorshipCreateRequest $request)
    {
        Sponsorship::create([
            ...$request->except('benefactor'),
            'benefactor_id' => $request->validated('benefactor.id'),
        ]);

        Benefactor::whereId($request->validated('benefactor.id'))->searchable();

        return response('', 204);
    }
}
