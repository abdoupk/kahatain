<?php

namespace App\Http\Controllers\V1\Occasions\MonthlySponsorships;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MonthlySponsorship\MonthlyBasketItemsResource;
use App\Models\MonthlyBasket;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListItemsOfMonthlyBasketController extends Controller implements HasMiddleware
{
    public function __invoke()
    {
        return MonthlyBasketItemsResource::collection(
            MonthlyBasket::with('inventory')
                ->paginate(page: request('page', 1))
        );
    }

    public static function middleware()
    {
        // TODO: Implement middleware() method.
    }
}
