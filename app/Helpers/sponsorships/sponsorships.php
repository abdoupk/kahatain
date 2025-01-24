<?php

use App\Models\Family;

function calculateDifferenceAfterMonthlySponsorship(Family $family, float $differenceBeforeSponsorship, float $sponsorshipFromAssociation): float
{
    $association_basket_value = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['association_basket_value'];

    return $differenceBeforeSponsorship - (($differenceBeforeSponsorship > 0 ? 1 : 0) * $association_basket_value) - ($sponsorshipFromAssociation + $family->aid->sum('amount'));
}

function monthlySponsorship(Family $family): void
{
    $family->load(['orphans.tenant', 'orphans.academicLevel', 'aid', 'secondSponsor', 'sponsor.incomes', 'housing', 'tenant']);

    $weights = calculateWeights($family);

    $differenceBeforeSponsorship = calculateDifferenceBeforeMonthlySponsorship($family, $weights);

    $sponsorshipRate = getPercentageForIncomeRate($family, $differenceBeforeSponsorship) / 100;

    $differenceAfterSponsorship = calculateDifferenceAfterMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipRate);

    $sponsorshipFromAssociation = calculateAssociationMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipRate);

    $income_rate = calculateIncomeRate($family);

    $total_income = calculateTotalIncomes($family);

    $differenceForRamadanSponsorship = calculateDifferenceForRamadanSponsorship($family, $weights);

    $family->update([
        'income_rate' => $income_rate,
        'total_income' => $total_income,
        'difference_before_monthly_sponsorship' => $differenceBeforeSponsorship,
        'difference_after_monthly_sponsorship' => $differenceAfterSponsorship,
        'monthly_sponsorship_rate' => $sponsorshipRate,
        'amount_from_association' => $sponsorshipFromAssociation,
        'ramadan_sponsorship_difference' => $differenceForRamadanSponsorship,
        'ramadan_basket_category' => getCategoryForRamadanBasket($family, $differenceForRamadanSponsorship),
    ]);

    $family->searchable();

    $family->orphans()->searchable();

    $sponsor = $family->sponsor();

    $sponsorIncomes = $sponsor->with('incomes')->first()->incomes();

    $sponsorIncomes->update([
        'total_income' => setTotalIncomeAttribute($sponsorIncomes->first()->toArray()),
    ]);

    $sponsor->searchable();
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
