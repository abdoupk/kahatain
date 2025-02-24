<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\Inventory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function getInventoryItems(): LengthAwarePaginator
{
    return search(Inventory::getModel())
        ->paginate(perPage: request()->integer('perPage', 10));
}
