<?php

use App\Models\Archive;
use Illuminate\Pagination\LengthAwarePaginator;

function getArchives(): LengthAwarePaginator
{
    return search(Archive::getModel())
        ->query(fn ($query) => $query->with(
            ['savedBy:id,first_name,last_name']
        )->withCount(['families', 'babies', 'orphans']))
        ->paginate(perPage: (int) request()?->input('perPage', 10));
}
