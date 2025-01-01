<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\Branch;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

/** @noinspection NullPointerExceptionInspection
 * @noinspection StaticClosureCanBeUsedInspection
 */
function getBranches(): LengthAwarePaginator
{
    return search(Branch::getModel())
        ->query(
            fn (Builder $query) => $query
                ->with(['president', 'city'])
                ->withCount(['families', 'members'])
        )
        ->paginate(perPage: request()->integer('perPage', 10));
}
