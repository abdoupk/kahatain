<?php

use App\Models\Family;
use App\Models\Sponsor;
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

function setTotalIncomeAttribute(array $incomes, Sponsor $sponsor): float
{
    if ($sponsor->is_unemployed) {
        return json_decode((string)$sponsor->load('tenant')->tenant['calculation'], true)['monthly_sponsorship']['unemployment_benefit'];
    }

    $incomes = Arr::only($incomes, ['account', 'other_income']);

    return array_reduce($incomes, function ($carry, $item) {
        if (is_array($item)) {
            $total = $carry;

            if (isset($item['ccp'])) {
                $total += (float) $item['ccp']['monthly_income'] + (float) $item['ccp']['balance'] + (float) $item['ccp']['performance_grant'] / 3;
            }

            if (isset($item['bank'])) {
                $total += (float) $item['bank']['monthly_income'] + (float) $item['bank']['balance'] + (float) $item['bank']['performance_grant'] / 3;
            }

            return $total;
        }

        return (float) $carry + (float) $item;
    }, 0);
}
