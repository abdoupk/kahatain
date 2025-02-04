<?php

namespace App\Http\Controllers\V1\Occasions\RamadanBasket;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Occasions\RamadanBasket\UpdateRamadanBasketRequest;
use App\Jobs\V1\Occasion\RamadanBasketItemsUpdatedJob;
use App\Models\RamadanBasket;
use Illuminate\Routing\Controllers\HasMiddleware;

class UpdateRamadanBasketItemsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        // TODO: Implement middleware() method.
    }

    public function __invoke(UpdateRamadanBasketRequest $request)
    {
        updateBasketItems($request->items, $request->deleted_items, RamadanBasket::query());

        dispatch(new RamadanBasketItemsUpdatedJob(auth()->user()));
    }
}
