<?php

use App\Models\Family;
use App\Models\Orphan;
use App\Models\Sponsor;

function calculateOrphanIncomes(Orphan $orphan): float
{
    if ($orphan->is_handicapped) {
        return calculateContributionsForHandicappedOrphan($orphan);
    }

    $calculation = json_decode((string) $orphan->load('tenant')->tenant['calculation'], true);

    if ($orphan->birth_date->age > 18) {
        if ($orphan->gender === 'male') {
            return calculateContributionsForMaleOrphan($orphan, $calculation);
        }

        return calculateContributionsForFemaleOrphan($orphan, $calculation);
    }

    return 0;
}

function calculateContributionsForSponsor(Sponsor $sponsor): float
{
    $calculation = json_decode((string) $sponsor->tenant['calculation'], true);

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
        'widowers_wife' => $sponsorContributions['widowers_wife'],
        'mother_of_a_supported_childhood' => $sponsorContributions['mother_of_a_supported_childhood'],
        default => 0
    };
}

function calculateContributionsForHandicappedOrphan(Orphan $orphan): float
{
    return json_decode(
        (string) $orphan->tenant['calculation'],
        true
    )['handicapped_contribution']['contribution'];
}

function calculateContributionsForMaleOrphan(Orphan $orphan, array $calculations): float
{
    $unemployedContribution = $calculations['unemployed_contribution']['orphans']['male_gt_18'];

    $unemploymentBenefit = $calculations['monthly_sponsorship']['unemployment_benefit'];

    if ($orphan->is_unemployed) {
        return match ($orphan->family_status) {
            'professional_boy' => $unemployedContribution['professional_boy'],
            'unemployed' => $unemployedContribution['unemployed'],
            'married_with_family' => $unemployedContribution['married_with_family'],
        } + (float) $unemploymentBenefit;
    }

    if ($orphan->academicLevel?->phase_key === 'university' && $orphan->academicLevel?->level === 'متخرج') {
        return $unemployedContribution['unemployed'];
    }

    $calculations = $calculations['percentage_of_contribution']['orphans']['male_gt_18'];

    return match ($orphan->family_status) {
        'college_boy' => $calculations['college_boy'] * $orphan->income,
        'worker_with_family' => $calculations['worker_with_family'] * $orphan->income,
        'worker_outside_family' => $calculations['worker_outside_family'] * $orphan->income,
        'married_with_family' => $calculations['married_with_family'] * $orphan->income,
        'married_outside_family' => $calculations['married_outside_family'] * $orphan->income,
        'professional_boy' => $unemployedContribution['professional_boy'],
        default => $unemployedContribution['unemployed']
    } / 100;
}

function calculateContributionsForFemaleOrphan(Orphan $orphan, array $calculations): float
{
    $atHomeWithNoIncome = $calculations['unemployed_contribution']['orphans']['female_gt_18']['at_home_with_no_income'];

    if ($orphan->academicLevel?->phase_key === 'university' && $orphan->academicLevel?->level === 'متخرج') {
        return $atHomeWithNoIncome;
    }

    if ($orphan->is_unemployed) {
        $unemploymentBenefit = $calculations['monthly_sponsorship']['unemployment_benefit'];

        return $atHomeWithNoIncome + (float) $unemploymentBenefit;
    }

    if (! $orphan->is_unemployed) {
        $calculations = $calculations['percentage_of_contribution']['orphans']['female_gt_18'];

        if ($orphan->family_status === 'at_home_with_no_income') {
            return 0;
        }

        return match ($orphan->family_status) {
            'college_girl' => $calculations['college_girl'] * $orphan->income,
            'professional_girl' => $calculations['professional_girl'] * $orphan->income,
            'at_home_with_income' => $calculations['at_home_with_income'] * $orphan->income,
            'single_female_employee' => $calculations['single_female_employee'] * $orphan->income,
            'married' => $calculations['married'] * $orphan->income,
            'divorced_with_family' => $calculations['divorced_with_family'] * $orphan->income,
            'divorced_outside_family' => $calculations['divorced_outside_family'] * $orphan->income,
            default => $atHomeWithNoIncome
        } / 100;
    }

    return $atHomeWithNoIncome;
}

function calculateContributionsForSecondSponsor(Family $family): float
{
    $percentage_of_contribution = json_decode((string) $family->tenant['calculation'], true)['percentage_of_contribution'];

    if (! property_exists($family, 'secondSponsor') || $family->secondSponsor === null) {
        return 0;
    }

    if ($family->secondSponsor->with_family) {
        return $percentage_of_contribution['second_sponsor']['with_family'] * $family->secondSponsor->income / 100;
    }

    return $percentage_of_contribution['second_sponsor']['outside_family'] * $family->secondSponsor->income / 100;
}
