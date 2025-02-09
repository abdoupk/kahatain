<?php

use App\Models\Benefactor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

function getBenefactors(): LengthAwarePaginator
{
    return search(Benefactor::getModel())
        ->query(fn ($query) => $query->withCount(['sponsorships']))
        ->paginate(perPage: request()->integer('perPage', 10));
}

function searchBenefactors(): Collection
{
    return search(Benefactor::getModel(), limit: LIMIT)->get();
}
