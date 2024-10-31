<?php

use App\Models\Family;
use App\Models\Orphan;
use App\Models\Sponsor;

function calculateOrphanIncomes(Orphan $orphan): float
{
    if ($orphan->is_handicapped) {
        return calculateContributionsForHandicappedOrphan($orphan);
    }

    $calculation = json_decode($orphan->tenant['calculation'], true);

    if ($orphan->gender === 'male') {
        return calculateContributionsForMaleOrphan($orphan, $calculation);
    }

    return calculateContributionsForFemaleOrphan($orphan, $calculation);
}

function calculateContributionsForSponsor(Sponsor $sponsor): float
{
    $calculation = json_decode($sponsor->tenant['calculation'], true);

    $sponsorPercentages = $calculation['percentage_of_contribution']['sponsor'];

    $sponsorContributions = $calculation['unemployed_contribution']['sponsor'];

    if (! $sponsor->is_unemployed) {
        return match ($sponsor->sponsor_type) {
            'other' => $sponsorPercentages['other'] *
            $sponsor->incomes?->total_income ?? 0,
            'widower' => $sponsorPercentages['widower'] *
            $sponsor->incomes?->total_income ?? 0,
            'widow' => $sponsorPercentages['widow'] *
            $sponsor->incomes?->total_income ?? 0,
            'widows_husband' => $sponsorPercentages['widows_husband'] *
            $sponsor->incomes?->total_income ?? 0,
            'widowers_wife' => $sponsorPercentages['widowers_wife'] * $sponsor->incomes?->total_income ?? 0,
            'mother_of_a_supported_childhood' => $sponsorPercentages['mother_of_a_supported_childhood'] *
            $sponsor->incomes?->total_income ?? 0,
        } / 100;
    }

    return match ($sponsor->sponsor_type) {
        'other' => $sponsorContributions['other'],
        'widower' => $sponsorContributions['widower'],
        'widow' => $sponsorContributions['widow'],
        'widows_husband' => $sponsorContributions['widows_husband'],
        'widows_wife' => $sponsorContributions['widows_wife'],
        'mother_of_a_supported_childhood' => $sponsorContributions['mother_of_a_supported_childhood'],
        default => 0
    } / 100;
}

function calculateContributionsForHandicappedOrphan(Orphan $orphan): float
{
    return json_decode(
        $orphan->tenant['calculation'],
        true
    )['handicapped_contribution']['contribution'];
}

function calculateContributionsForMaleOrphan(Orphan $orphan, array $calculations): float
{
    if ($orphan->is_unemployed) {
        $calculations = $calculations['unemployed_contribution']['orphans']['male_gt_18'];

        return match ($orphan->family_status) {
            'professional_boy' => $calculations['professional_boy'],
            'unemployed' => $calculations['unemployed'],
            'married_with_family' => $calculations['married_with_family'],
            default => 0
        };
    }
    $calculations = $calculations['percentage_of_contribution']['orphans']['male_gt_18'];

    return match ($orphan->family_status) {
        'college_boy' => $calculations['college_boy'] * $orphan->income,
        'worker_with_family' => $calculations['worker_with_family'] * $orphan->income,
        'worker_outside_family' => $calculations['worker_outside_family'] * $orphan->income,
        'married_with_family' => $calculations['married_with_family'] * $orphan->income,
        'married_outside_family' => $calculations['married_outside_family'] * $orphan->income,
        default => 0
    } / 100;
}

function calculateContributionsForFemaleOrphan(Orphan $orphan, array $calculations): float
{
    if (! $orphan->is_unemployed) {
        $calculations = $calculations['percentage_of_contribution']['orphans']['female_gt_18'];

        return match ($orphan->family_status) {
            'college_girl' => $calculations['college_girl'] * $orphan->income,
            'professional_girl' => $calculations['professional_girl'] * $orphan->income,
            'at_home_with_income' => $calculations['at_home_with_income'] * $orphan->income,
            'single_female_employee' => $calculations['single_female_employee'] * $orphan->income,
            'married' => $calculations['married'] * $orphan->income,
            'divorced_with_family' => $calculations['divorced_with_family'] * $orphan->income,
            'divorced_outside_family' => $calculations['divorced_outside_family'] * $orphan->income,
            default => 0
        } / 100;
    }

    return $calculations['unemployed_contribution']['orphans']['female_gt_18']['at_home_with_no_income'];
}

function calculateContributionsForSecondSponsor(Family $family): float
{
    $percentage_of_contribution = json_decode($family->tenant['calculation'], true)['percentage_of_contribution'];

    if (isset($family->secondSponsor)) {
        return match ($family->secondSponsor?->with_family) {
            true => $percentage_of_contribution['second_sponsor']['with_family'] * $family->secondSponsor->income,
            false => $percentage_of_contribution['second_sponsor']['outside_family'] * $family->secondSponsor->income,
            default => 0
        } / 100;
    }

    return 0;
}
