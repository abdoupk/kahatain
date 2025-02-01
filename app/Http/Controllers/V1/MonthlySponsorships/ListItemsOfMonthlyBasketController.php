<?php

namespace App\Http\Controllers\V1\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MonthlySponsorship\MonthlyBasketItemsResource;
use App\Models\MonthlyBasket;

class ListItemsOfMonthlyBasketController extends Controller
{
    public function __invoke()
    {
        return MonthlyBasketItemsResource::collection(MonthlyBasket::with('inventory:id,name,unit')->paginate(page: request('page', 1)));
    }
}
