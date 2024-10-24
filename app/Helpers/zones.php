<?php

use App\Models\Zone;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** @noinspection NullPointerExceptionInspection */
function getZones(): LengthAwarePaginator
{
    return search(Zone::getModel())
        ->query(fn ($query) => $query->withCount('families'))
        ->paginate(perPage: request()->integer('perPage', 10));
}
