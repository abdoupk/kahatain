<?php

use App\Models\Family;
use App\Models\Orphan;

function calculateTotalIncomes(Family $family): float
{
    return (float)$family->sponsor?->incomes->total_income
        + (float)$family->orphans?->sum('income')
        + $family->secondSponsor?->income;
}

function calculateIncomeRate(Family $family): float
{
    return round(calculateIncomes($family) / calculateWeights($family), 2);
}

function calculateIncomes(Family $family)
{
    return $family->orphans->sum(function (Orphan $orphan) {
            return calculateOrphanIncomes($orphan);
        }) +
        (calculateContributionsForSponsor($family->sponsor) - getTenantPrice($family))
        + calculateContributionsForSecondSponsor($family);
}

function getTenantPrice(Family $family): float
{
    return $family->housing->where('name', '=', 'tenant')->first()
        ->value ?? 0;
}
