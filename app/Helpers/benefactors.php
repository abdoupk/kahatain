<?php

use App\Models\Benefactor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function getBenefactors(): LengthAwarePaginator
{
    return search(Benefactor::getModel())
        ->query(fn ($query) => $query->withCount(['sponsorships']))
        ->paginate(perPage: request()?->integer('perPage', 10));
}
