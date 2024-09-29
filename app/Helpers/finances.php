<?php

use App\Models\Finance;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

function getFinances(): LengthAwarePaginator
{
    return search(Finance::getModel())
        ->query(fn (Builder $query) => $query->with(['creator', 'receiver']))
        ->paginate(perPage: request()->integer('perPage', 10));
}

function getFinancesForExport(): Collection
{
    return search(Finance::getModel(), limit: LIMIT)
        ->query(fn (Builder $query) => $query->with(
            [
                'creator:id,first_name,last_name',
                'receiver:id,first_name,last_name',
            ]
        ))
        ->get();
}
