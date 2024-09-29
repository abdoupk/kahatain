<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/** @noinspection NullPointerExceptionInspection */
function getMembers(): LengthAwarePaginator
{
    return search(User::getModel())
        ->query(fn ($query) => $query->with('zone'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function searchMembers(): Collection
{
    return search(User::getModel(), limit: 100)->get();
}
