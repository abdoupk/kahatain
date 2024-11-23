<?php

use App\Models\Transcript;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function getPhaseStudents(int $academic_level_id): LengthAwarePaginator
{
    return search(Transcript::getModel(),
        "AND academic_level_id = $academic_level_id"
    )
        ->query(fn ($query) => $query->with(['subjects', 'orphan']))
        ->paginate(perPage: request()?->integer('perPage', 10));
}
