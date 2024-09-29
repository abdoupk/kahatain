<?php

use App\Models\Need;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function getNeeds(): LengthAwarePaginator
{
    return search(Need::getModel())
        ->query(fn ($query) => $query
            ->with(['needable']))
        ->paginate(perPage: request()?->input('perPage', 10));
}

function getNeedsGroupByType(): array
{
    $needs = Need::whereYear(
        'created_at',
        date('Y')
    )->groupBy('needable_type')
        ->selectRaw('count(*) as count, needable_type')
        ->get();

    return [
        'labels' => $needs->pluck('needable_type')->toArray(),
        'data' => $needs->pluck('count')->toArray(),
    ];
}

function getNeedsGroupByCreatedDate(): array
{
    return array_replace(
        array_fill(1, 13, 0),
        Need::whereYear('created_at', date('Y'))
            ->selectRaw(
                'count(*) as count, EXTRACT(MONTH FROM created_at) as month'
            )
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray()
    );
}
