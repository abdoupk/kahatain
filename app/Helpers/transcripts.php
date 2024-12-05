<?php

use App\Models\Orphan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

function getOrphansForTranscripts(): LengthAwarePaginator
{
    return search(Orphan::getModel(), additional_filters: FILTER_STUDENTS)
        ->query(fn (Builder $query) => $query->with(['academicLevel', 'transcripts', 'sponsor:id,first_name,last_name,phone_number', 'institution']))
        ->paginate(perPage: request()->integer('perPage', 10));
}
