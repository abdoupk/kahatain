<?php

use App\Models\Family;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

function getFamilies(): LengthAwarePaginator
{
    return search(Family::getModel())
        ->query(fn ($query) => $query->with(['zone:id,name', 'sponsor:id,first_name,last_name,family_id'])
            ->withCount('orphans')
        )
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function getFamiliesForExport(): Collection
{
    return search(Family::getModel(), limit: 10000)
        ->query(fn ($query) => $query
            ->with(['zone:id,name',
                'branch:id,name',
                'sponsor.incomes',
                'secondSponsor:id,income,family_id',
                'orphans:id,income,family_id',
            ])
            ->withCount('orphans'))
        ->get();
}

function searchFamilies(): \Illuminate\Database\Eloquent\Collection
{
    return search(Family::getModel(), limit: LIMIT)->get();
}

function getFamiliesPosition(): array
{
    return Family::select(['location', 'address', 'name'])
        ->get()->toArray();
}

function setTotalIncomeAttribute(array $incomes): float
{
    return array_reduce($incomes, function ($carry, $item) {
        if (is_array($item)) {
            if (isset($item['ccp'])) {
                return $carry + (float) $item['ccp']['monthly_income'] + (float) $item['ccp']['balance'] + (float) $item['ccp']['performance_grant'] / 3;
            }

            if (isset($item['bank'])) {
                return $carry + (float) $item['bank']['monthly_income'] + (float) $item['bank']['balance'] + (float) $item['bank']['performance_grant'] / 3;
            }
        }

        return (float) $carry + (float) $item;
    }, 0);
}
