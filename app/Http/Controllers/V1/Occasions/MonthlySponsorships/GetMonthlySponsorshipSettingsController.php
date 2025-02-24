<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class GetMonthlySponsorshipSettingsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(json_decode(auth()->user()->tenant->calculation)->monthly_sponsorship ?? []);
    }
}
