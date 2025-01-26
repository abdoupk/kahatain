<?php

use App\Enums\SponsorType;
use App\Models\Family;

function calculateDifferenceAfterMonthlySponsorship(Family $family, float $differenceBeforeSponsorship, float $sponsorshipFromAssociation): float
{
    $association_basket_value = json_decode($family->tenant['calculation'], true)['monthly_sponsorship']['association_basket_value'];

    return $differenceBeforeSponsorship - (($differenceBeforeSponsorship > 0 ? 1 : 0) * $association_basket_value) - ($sponsorshipFromAssociation + $family->aid->sum('amount'));
}

function monthlySponsorship(Family $family): void
{
    $family->load(['orphans.tenant', 'orphans.academicLevel', 'aid', 'secondSponsor', 'sponsor.incomes', 'housing', 'tenant']);

    $calculations = json_decode($family->tenant['calculation'], true);

    $weights = calculateWeights($family, $calculations);

    $income_rate = calculateIncomeRate($family, $calculations);

    $total_income = calculateTotalIncomes($family);

    $differenceBeforeSponsorship = calculateDifferenceBeforeMonthlySponsorship($weights, $income_rate, $calculations);

    $sponsorshipRate = getPercentageForIncomeRate($family, $differenceBeforeSponsorship) / 100;

    $sponsorshipFromAssociation = calculateAssociationMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipRate);

    $differenceAfterSponsorship = calculateDifferenceAfterMonthlySponsorship($family, $differenceBeforeSponsorship, $sponsorshipFromAssociation);

    $differenceForRamadanSponsorship = calculateDifferenceForRamadanSponsorship($weights, $income_rate, $calculations);

    $individualsCount = calculateNumberOfIndividualsInFamily($family);

    $family->update([
        'total_income' => $total_income,
        'income_rate' => $income_rate,
        'monthly_sponsorship_rate' => $sponsorshipRate,
        'difference_before_monthly_sponsorship' => $differenceBeforeSponsorship,
        'amount_from_association' => $sponsorshipFromAssociation,
        'difference_after_monthly_sponsorship' => $differenceAfterSponsorship,
        'ramadan_sponsorship_difference' => $differenceForRamadanSponsorship,
        'ramadan_basket_category' => getCategoryForRamadanBasket($family, $differenceForRamadanSponsorship),
        'eid_al_adha_status' => getStatusForEidAlAdha($individualsCount, $income_rate, $calculations),
    ]);

    $family->searchable();

    $family->orphans()->searchable();

    $family->sponsor()->searchable();
}

function calculateDifferenceBeforeMonthlySponsorship(float $totalWeights, float $incomeRate, array $calculation): float
{
    $threshold = $calculation['monthly_sponsorship']['threshold'];

    return ($threshold - $incomeRate) * $totalWeights;
}

function calculateDifferenceForRamadanSponsorship(float $totalWeights, float $incomeRate, array $calculation): float
{
    $threshold = $calculation['ramadan_sponsorship']['threshold'];

    return ($threshold - $incomeRate) * $totalWeights;
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

function getStatusForEidAlAdha(int $individualsCount, float $incomeRate, $calculation): ?string
{
    $sponsorship = $calculation['eid_al_adha_sponsorship'];

    if ($incomeRate > $sponsorship['threshold']) {
        return 'dont_benefit';
    }

    if ($incomeRate < $sponsorship['threshold']) {
        if ($individualsCount <= $sponsorship['categories']['meat']['individuals_count']) {
            return 'meat';
        } elseif ($individualsCount > $sponsorship['categories']['benefits']['individuals_count']) {
            return 'benefit';
        }
    }

    return null;
}

function calculateNumberOfIndividualsInFamily(Family $family): int
{
    $total = 0;

    if ($family->sponsor->sponsor_type === SponsorType::WIDOWS_HUSBAND->value) {
        $total += 2;
    }

    if ($family->secondSponsor?->with_family) {
        $total += 1;
    }

    return $total + 1 + $family->orphans->count();
}
