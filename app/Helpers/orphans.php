<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\Orphan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

function getOrphans(): LengthAwarePaginator
{
    return search(Orphan::getModel())
        ->query(fn ($query) => $query->with('academicLevel'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function searchOrphans(): Collection
{
    return search(Orphan::getModel(), limit: LIMIT)->get();
}

function getOrphansForExport(): Collection
{
    return search(Orphan::getModel(), limit: 10000)
        ->query(fn ($query) => $query->with(
            ['academicLevel',
                'pantsSize',
                'shoesSize',
                'shirtSize',
            ]
        ))
        ->get();
}
