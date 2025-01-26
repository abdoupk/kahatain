<?php

use App\Models\Family;

function calculateDifferenceAfterMonthlySponsorship(Family $family, float $differenceBeforeSponsorship, float $sponsorshipFromAssociation): float
{
    $association_basket_value = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['association_basket_value'];
    ray($differenceBeforeSponsorship, $sponsorshipFromAssociation);
    $a = $differenceBeforeSponsorship - (($differenceBeforeSponsorship > 0 ? 1 : 0) * $association_basket_value) - ($sponsorshipFromAssociation + $family->aid->sum('amount'));
    ray($a);

    return $a;
}

function monthlySponsorship(Family $family): void
{
    $family->load(['orphans.tenant', 'orphans.academicLevel', 'aid', 'secondSponsor', 'sponsor.incomes', 'housing', 'tenant']);

    $weights = calculateWeights($family);

    $income_rate = calculateIncomeRate($family);

    $total_income = calculateTotalIncomes($family);

    $family->update([
        'total_income' => $total_income,
        'income_rate' => $income_rate,
    ]);

    $differenceBeforeSponsorship = calculateDifferenceBeforeMonthlySponsorship($family, $weights);

    $sponsorshipRate = getPercentageForIncomeRate($family, $differenceBeforeSponsorship) / 100;

    $sponsorshipFromAssociation = calculateAssociationMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipRate);

    $differenceAfterSponsorship = calculateDifferenceAfterMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipFromAssociation);

    $differenceForRamadanSponsorship = calculateDifferenceForRamadanSponsorship($family, $weights);

    $family->update([
        'monthly_sponsorship_rate' => $sponsorshipRate,
        'difference_before_monthly_sponsorship' => $differenceBeforeSponsorship,
        'amount_from_association' => $sponsorshipFromAssociation,
        'difference_after_monthly_sponsorship' => $differenceAfterSponsorship,
        'ramadan_sponsorship_difference' => $differenceForRamadanSponsorship,
        'ramadan_basket_category' => getCategoryForRamadanBasket($family, $differenceForRamadanSponsorship),
    ]);

    $family->searchable();

    $family->orphans()->searchable();

    $family->sponsor()->searchable();
}

function calculateDifferenceBeforeMonthlySponsorship(Family $family, float $totalWeights): float
{
    $threshold = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['threshold'];

    return ($threshold - $family->income_rate) * $totalWeights;
}

function calculateDifferenceForRamadanSponsorship(Family $family, float $totalWeights): float
{
    $threshold = json_decode($family->tenant['calculation'], true)['ramadan_sponsorship']['threshold'];

    return ($threshold - $family->income_rate) * $totalWeights;
}

function calculateAssociationMonthlySponsorship(Family $family, float $differenceBeforeSponsorship, float $sponsorshipRate): float
{
    $associationBasketValue = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['association_basket_value'] ?? 0;

    return ($differenceBeforeSponsorship * $sponsorshipRate)
        - (($differenceBeforeSponsorship > 0 ? 1 : 0) * $associationBasketValue)
        + $family->aid()->sum('amount');
}

function getPercentageForIncomeRate(Family $family, float $differenceBeforeSponsorship): float
{
    $categories = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['categories'];

    foreach ($categories as $category) {
        if ($differenceBeforeSponsorship >= $category['minimum'] && $differenceBeforeSponsorship < $category['maximum']) {
            return $category['value'];
        }
    }

    return 0.0;
}

function getCategoryForRamadanBasket(Family $family, float $differenceForRamadanBasketSponsorship): string
{
    $categories = json_decode($family->tenant['calculation'], true)['ramadan_sponsorship']['categories'];

    foreach ($categories as $category) {
        if ($differenceForRamadanBasketSponsorship >= $category['minimum'] && $differenceForRamadanBasketSponsorship < $category['maximum']) {
            return $category['category'];
        }
    }

    return __('no_category_for_ramadan_basket');
}
