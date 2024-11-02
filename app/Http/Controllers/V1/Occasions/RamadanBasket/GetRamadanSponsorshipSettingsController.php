<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;

class GetRamadanSponsorshipSettingsController extends Controller
{
    public function __invoke()
    {
        return response()->json(json_decode(auth()->user()->tenant->calculation)->ramadan_sponsorship ?? []);
    }
}
