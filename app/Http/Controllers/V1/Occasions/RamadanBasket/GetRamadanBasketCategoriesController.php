<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;

class GetRamadanBasketCategoriesController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'categories' => collect(json_decode(auth()->user()->tenant->calculation, true)['ramadan_sponsorship']['categories'])->pluck('category')->toArray(),
        ]);
    }
}
