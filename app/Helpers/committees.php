<?php

use App\Models\Committee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** @noinspection NullPointerExceptionInspection */
function getCommittees(): LengthAwarePaginator
{
    ray(search(Committee::getModel())->get());

    return search(Committee::getModel())
        ->query(fn ($query) => $query->withCount('members'))
        ->paginate(perPage: request()->integer('perPage', 10));
}
