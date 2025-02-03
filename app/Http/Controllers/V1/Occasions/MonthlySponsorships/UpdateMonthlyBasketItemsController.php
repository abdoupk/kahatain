<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\MonthlySponsorship\UpdateMonthlyBasketRequest;
use App\Jobs\V1\Occasion\MonthlyBasketItemsUpdatedJob;
use App\Models\MonthlyBasket;

class UpdateMonthlyBasketItemsController extends Controller
{
    public function __invoke(UpdateMonthlyBasketRequest $request)
    {
        updateBasketItems($request->items, MonthlyBasket::query());

        dispatch(new MonthlyBasketItemsUpdatedJob(auth()->user()));
    }
}
