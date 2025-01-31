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

function calculateIncomeRate(Family $family, array $calculation): float
{
    return round(calculateIncomes($family) / calculateWeights($family, $calculation), 2);
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
    return (float) Housing::whereFamilyId($family->id)->whereName('tenant')->first()?->value ?? 0;
}

function calculateOrphanExactIncome(Orphan $orphan): float|int|null
{
    $monthlySponsorship = json_decode($orphan->load(['academicLevel', 'tenant'])->tenant['calculation'], true)['monthly_sponsorship'];

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

function setUnemployedOrphanIncome(Orphan $orphan): float
{
    $calculation = json_decode($orphan->load(['tenant'])->tenant['calculation'], true);

    $atHomeWithNoIncome = $calculation['unemployed_contribution']['orphans']['female_gt_18']['at_home_with_no_income'];

    $unemployedContribution = $calculation['unemployed_contribution']['orphans']['male_gt_18'];

    if ($orphan->gender === 'male') {
        $defaultIncome = match ($orphan->family_status) {
            'professional_boy' => $unemployedContribution['professional_boy'],
            'unemployed' => $unemployedContribution['unemployed'],
            'married_with_family' => $unemployedContribution['married_with_family'],
        };
    } else {
        $defaultIncome = $atHomeWithNoIncome;
    }

    return $orphan->income;
}

function setHandicappedOrphanIncome(Orphan $orphan): float
{
    $calculation = json_decode($orphan->load(['tenant'])->tenant['calculation'], true);

    return $calculation['handicapped_contribution']['contribution'];
}
