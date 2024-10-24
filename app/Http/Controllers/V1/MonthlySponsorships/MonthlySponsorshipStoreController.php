<?php

namespace App\Http\Controllers\V1\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MonthlySponsorship\MonthlySponsorshipCreateRequest;

class MonthlySponsorshipStoreController extends Controller
{
    public function __invoke(MonthlySponsorshipCreateRequest $request) {}
}
