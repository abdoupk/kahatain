<?php

use App\Models\Family;

function calculateDifferenceAfterMonthlySponsorship(Family $family, float $differenceBeforeSponsorship, float $sponsorshipFromAssociation): float
{
    $association_basket_value = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['association_basket_value'];

    return $differenceBeforeSponsorship - max($differenceBeforeSponsorship, $association_basket_value) - ($sponsorshipFromAssociation + $family->aid->sum('amount'));
}

function monthlySponsorship(Family $family): void
{
    $family->load(['orphans', 'aid', 'secondSponsor', 'sponsor.incomes', 'housing']);

    $weights = calculateWeights($family);

    $differenceBeforeSponsorship = calculateDifferenceBeforeMonthlySponsorship($family, $weights);

    $sponsorshipRate = getPercentageForIncomeRate($family, $differenceBeforeSponsorship);

    $differenceAfterSponsorship = calculateDifferenceAfterMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipRate);

    $sponsorshipFromAssociation = calculateAssociationMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipRate);

    $income_rate = calculateIncomeRate($family);
    $total_income = calculateTotalIncomes($family);

    $family->update([
        'income_rate' => $income_rate,
        'total_income' => $total_income,
        'difference_before_monthly_sponsorship' => $differenceBeforeSponsorship,
        'difference_after_monthly_sponsorship' => $differenceAfterSponsorship,
        'monthly_sponsorship_rate' => $sponsorshipRate,
        'amount_from_association' => $sponsorshipFromAssociation,
    ]);
}

function calculateDifferenceBeforeMonthlySponsorship(Family $family, float $totalWeights): float
{
    $threshold = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['threshold'];

    return ($threshold - $family->total_income) * $totalWeights;
}

function calculateAssociationMonthlySponsorship(Family $family, float $differenceBeforeSponsorship, float $sponsorshipRate): float
{
    $associationBasketValue = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['association_basket_value'] ?? 0;

    return $differenceBeforeSponsorship * $sponsorshipRate
        - max(0, $differenceBeforeSponsorship) * $associationBasketValue
        + $family->aid->sum('amount');
}

function getPercentageForIncomeRate(Family $family, float $differenceBeforeSponsorship): float
{
    $categories = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['categories'];

    foreach ($categories as $category) {
        if ($differenceBeforeSponsorship > $category['minimum'] && $differenceBeforeSponsorship < $category['maximum']) {
            return $category['value'];
        }
    }

    return 0.0;
}
