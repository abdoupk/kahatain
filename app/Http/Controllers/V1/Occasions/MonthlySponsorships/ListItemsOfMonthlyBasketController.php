<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MonthlySponsorship\MonthlyBasketItemsResource;
use App\Models\MonthlyBasket;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListItemsOfMonthlyBasketController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_monthly_basket_monthly_sponsorships'];
    }

    public function __invoke()
    {
        return MonthlyBasketItemsResource::collection(
            MonthlyBasket::with('inventory')
                ->paginate(perPage: 10, page: request('page', 1))
        );
    }
}
