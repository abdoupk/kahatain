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

function calculateIncomeRate(Family $family, float $weights): float
{
    return round(calculateIncomes($family) / $weights, 2);
}

function calculateIncomes(Family $family)
{
    return $family->orphans->sum(fn(Orphan $orphan) => calculateOrphanIncomes($orphan)) +
        (calculateContributionsForSponsor($family->sponsor) - getTenantPrice($family))
        + calculateContributionsForSecondSponsor($family);
}

function getTenantPrice(Family $family): float
{
    return (float) Housing::whereFamilyId($family->id)->whereName('tenant')->first()?->value ?? 0;
}

function calculateOrphanExactIncome(Orphan $orphan): float|int|null
{
    $monthlySponsorship = json_decode((string)$orphan->load(['academicLevel', 'tenant'])->tenant['calculation'], true)['monthly_sponsorship'];

    $scholarshipMap = [
        'ليسانس' => $monthlySponsorship['university_scholarship_bachelor'],
        'الأولى ماستر' => $monthlySponsorship['university_scholarship_master_one'],
        'الثانية ماستر' => $monthlySponsorship['university_scholarship_master_two'],
        'دكتوراه' => $monthlySponsorship['university_scholarship_doctorate'],
    ];

    foreach ($scholarshipMap as $pattern => $scholarship) {
        if (Str::contains($orphan->academicLevel?->level, $pattern)) {
            return $scholarship / 3;
        }
    }

    return $orphan->income;
}

function setHandicappedOrphanIncome(Orphan $orphan): float
{
    return json_decode((string)$orphan->load(['tenant'])->tenant['calculation'], true)['handicapped_contribution']['contribution'];
}
