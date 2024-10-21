<?php

use App\Models\Benefactor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function getBenefactors(): LengthAwarePaginator
{
    return search(Benefactor::getModel())
        ->paginate(perPage: request()?->integer('perPage', 10));
}
