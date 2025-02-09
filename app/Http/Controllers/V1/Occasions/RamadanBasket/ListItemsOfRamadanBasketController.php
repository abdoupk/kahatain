<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MonthlySponsorship\MonthlyBasketItemsResource;
use App\Models\RamadanBasket;
use Illuminate\Routing\Controllers\HasMiddleware;

class ListItemsOfRamadanBasketController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return ['can:update_ramadan_basket_ramadan_baskets'];
    }

    public function __invoke()
    {
        return MonthlyBasketItemsResource::collection(
            RamadanBasket::with('inventory')
                ->paginate(perPage: 10, page: request('page', 1))
        );
    }
}
