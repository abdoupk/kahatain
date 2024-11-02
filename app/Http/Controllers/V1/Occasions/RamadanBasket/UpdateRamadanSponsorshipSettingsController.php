<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\RamadanBasket\UpdateRamadanSponsorshipSettingsRequest;

class UpdateRamadanSponsorshipSettingsController extends Controller
{
    public function __invoke(UpdateRamadanSponsorshipSettingsRequest $request)
    {
        $data = json_decode(auth()->user()->tenant->calculation, true);

        $data['ramadan_sponsorship'] = array_replace($data['ramadan_sponsorship'], $request->all());

        auth()->user()->tenant->update(['calculation' => json_encode($data)]);

        //        dispatch(new MonthlySponsorshipSettingsUpdatedJob(auth()->user()));

        return response('', 204);
    }
}
