<?php

use App\Models\Family;
use App\Models\Housing;
use App\Models\Orphan;

function calculateTotalIncomes(Family $family): float
{
    return (float) $family->sponsor?->incomes->total_income
        + (float) $family->orphans?->sum('income')
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
    ray((float) Housing::whereFamilyId($family->id)->whereName('tenant')->first()?->value ?? 0, 'housing value');

    return (float) Housing::whereFamilyId($family->id)->whereName('tenant')->first()?->value ?? 0;
}

function calculateOrphanExactIncome(Orphan $orphan): float|int|null
{
    $calculation = json_decode($orphan->load(['academicLevel', 'tenant'])->tenant['calculation'], true)['monthly_sponsorship'];

    $scholarshipMap = [
        'ليسانس' => $calculation['university_scholarship_bachelor'],
        'الأولى ماستر' => $calculation['university_scholarship_master_one'],
        'الثانية ماستر' => $calculation['university_scholarship_master_two'],
        'دكتوراه' => $calculation['university_scholarship_doctorate'],
    ];

    foreach ($scholarshipMap as $pattern => $scholarship) {
        if (Str::contains($orphan->academicLevel?->level, $pattern)) {
            return $orphan->income + ($scholarship / 3);
        }
    }

    return $orphan->income;
}

function setUnemployedOrphanIncome(Orphan $orphan): float
{
    $calculation = json_decode($orphan->load(['tenant'])->tenant['calculation'], true)['monthly_sponsorship'];

    return $orphan->income + $calculation['unemployment_benefit'];
}
