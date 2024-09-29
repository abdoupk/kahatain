<?php

use App\Models\Family;
use App\Models\Orphan;
use App\Models\Sponsor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

function getFamilies(): LengthAwarePaginator
{
    return search(Family::getModel())
        ->query(fn ($query) => $query->with('zone'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function getFamiliesForExport(): Collection
{
    return search(Family::getModel(), limit: 10000)
        ->query(fn ($query) => $query
            ->with(['zone:id,name',
                'branch:id,name',
                'sponsor.incomes',
                'secondSponsor:id,income,family_id',
                'orphans:id,income,family_id',
            ])
            ->withCount('orphans'))
        ->get();
}

function searchFamilies(): \Illuminate\Database\Eloquent\Collection
{
    return search(Family::getModel(), limit: LIMIT)->get();
}

function calculateTotalIncomes(Family $family): float
{
    return (float) $family->sponsor?->incomes->total_income
        + (float) $family->orphans?->sum('income')
        + $family->secondSponsor?->income;
}

/**
 * @throws JsonException
 */
function calculateIncomeRate(Family $family): float
{
    return round(calculateIncomes($family) / calculateWeights($family), 2);
}

/**
 * @throws JsonException
 */
function calculateIncomes(Family $family)
{
    return $family->orphans->sum(function (Orphan $orphan) {
        return calculateOrphanIncomes($orphan);
    }) + calculateContributionsForSponsor($family->sponsor);
}

/**
 * @throws JsonException
 */
function calculateOrphanIncomes(Orphan $orphan): float
{
    if ($orphan->is_handicapped) {
        return calculateContributionsForHandicappedSponsor($orphan);
    }

    $calculation = json_decode($orphan->tenant['calculation'], true, 512, JSON_THROW_ON_ERROR);

    if ($orphan->gender === 'male') {
        return calculateContributionsForMaleOrphan($orphan, $calculation);
    }
    return calculateContributionsForFemaleOrphan($orphan, $calculation);
}

/**
 * @throws JsonException
 */
function calculateWeights(Family $family): float
{
    $calculationWeights = json_decode(
        $family->tenant['calculation'],
        true,
        512,
        JSON_THROW_ON_ERROR
    )['weights']['orphans'];

    return $family->orphans->sum(
        function (Orphan $orphan) use ($calculationWeights) {
            return calculateOrphanWeights(
                $orphan,
                $calculationWeights
            );
        }
    ) + calculateSponsorWeights($family);
}

/**
 * @throws JsonException
 */
function calculateSponsorWeights(Family $family): float
{
    $weights = json_decode($family->tenant['calculation'], true, 512, JSON_THROW_ON_ERROR)['weights']['sponsor'];

    return match ($family->sponsor->sponsor_type) {
        'other' => $weights['other'],
        'widower' => $weights['widower'],
        'widow' => $weights['widow'],
        'widows_husband' => $weights['widows_husband'],
        'mother_of_a_supported_childhood' => $weights['mother_of_a_supported_childhood'],
        'widowers_wife' => $weights['widowers_wife'],
    };
}

/**
 * @throws JsonException
 */
function calculateOrphanWeights(Orphan $orphan, array $orphanWeights): float
{
    if ($orphan->is_handicapped) {
        return json_decode($orphan->tenant['calculation'], true, 512, JSON_THROW_ON_ERROR)['weights']['handicapped'];
    }

    if ($orphan->birth_date->age < 18) {
        return calculateWeightForOrphanBelow18($orphan, $orphanWeights);
    }
    if ($orphan->gender === 'male') {
        return calculateWeightForOrphanMaleOlderThan18($orphan, $orphanWeights);
    }
    return calculateWeightForOrphanFemaleOlderThan18($orphan, $orphanWeights);
}

function calculateWeightForOrphanFemaleOlderThan18(Orphan $orphan, array $weights): float
{
    $weights = $weights['female_gt_18'];

    return match ($orphan->family_status) {
        'college_girl' => $weights['college_girl'],
        'professional_girl' => $weights['professional_girl'],
        'at_home_with_no_income' => $weights['at_home_with_no_income'],
        'at_home_with_income' => $weights['at_home_with_income'],
        'single_female_employee' => $weights['single_female_employee'],
        'married' => $weights['married'],
        'divorced' => $weights['divorced'],
    };
}

function calculateWeightForOrphanMaleOlderThan18(Orphan $orphan, array $weights): float
{
    $weights = $weights['female_gt_18'];

    return match ($orphan->family_status) {
        'college_boy' => $weights['college_boy'],
        'professional_boy' => $weights['professional_boy'],
        'unemployed' => $weights['unemployed'],
        'worker_with_family' => $weights['worker_with_family'],
        'worker_outside_family' => $weights['worker_outside_family'],
        'married_with_family' => $weights['married_with_family'],
        'married_outside_family' => $weights['married_outside_family'],
    };
}

function calculateWeightForOrphanBelow18(Orphan $orphan, $weights): float
{
    if (date('m') <= 9 && date('m') >= 6) {
        if ($orphan->birth_date->age < 2) {
            return $weights['lt_18']['outside_academic_season']['baby'];
        }

        if ($orphan->birth_date->age <= 5 && $orphan->birth_date->age > 2) {
            return $weights['lt_18']['outside_academic_season']['below_school_age'];
        }

        if ($orphan->academicLevel->level === 'مفصول') {
            return $weights['lt_18']['outside_academic_season']['dismissed'];
        }

        if ($orphan->family_status === 'professional_girl' || $orphan->family_status === 'professional_boy') {
            return $weights['lt_18']['outside_academic_season']['professionals'];
        }

        return match ($orphan->academicLevel->phase) {
            'الطور الابتدائي' => $weights['lt_18']['outside_academic_season']['elementary_school'],
            'الطور المتوسط' => $weights['lt_18']['outside_academic_season']['middle_school'],
            'الطور الثانوي' => $weights['lt_18']['outside_academic_season']['high_school'],
            default => 1
        };
    }
    if ($orphan->birth_date->age < 2) {
        return $weights['lt_18']['during_academic_season']['baby'];
    }

    if ($orphan->birth_date->age <= 5 && $orphan->birth_date->age > 2) {
        return $weights['lt_18']['during_academic_season']['below_school_age'];
    }

    if ($orphan->academicLevel->level === 'مفصول') {
        return $weights['lt_18']['during_academic_season']['dismissed'];
    }

    if ($orphan->family_status === 'professional_girl' || $orphan->family_status === 'professional_boy') {
        return $weights['lt_18']['during_academic_season']['professionals'];
    }

    return match ($orphan->academicLevel->phase) {
        'الطور الابتدائي' => $weights['lt_18']['during_academic_season']['elementary_school'],
        'الطور المتوسط' => $weights['lt_18']['during_academic_season']['middle_school'],
        'الطور الثانوي' => $weights['lt_18']['during_academic_season']['high_school'],
        default => 1
    };
}

/**
 * @throws JsonException
 */
function calculateContributionsForSponsor(Sponsor $sponsor): float
{
    $calculation = json_decode($sponsor->tenant['calculation'], true, 512, JSON_THROW_ON_ERROR);

    $sponsorPercentages = $calculation['percentage_of_contribution']['sponsor'];

    $sponsorContributions = $calculation['unemployed_contribution']['sponsor'];

    if ($sponsor->is_unemployed) {
        return match ($sponsor->sponsor_type) {
            'other' => $sponsorPercentages['other'] *
                $sponsor->incomes->total_income,
            'widower' => $sponsorPercentages['widower'] *
                $sponsor->incomes->total_income,
            'widow' => $sponsorPercentages['widow'] *
                $sponsor->incomes->total_income,
            'widows_husband' => $sponsorPercentages['widows_husband'] *
                $sponsor->incomes->total_income,
            'widowers_wife' => $sponsorPercentages['widowers_wife'] * $sponsor->incomes->total_income,
            'mother_of_a_supported_childhood' => $sponsorPercentages['mother_of_a_supported_childhood'] *
                $sponsor->incomes->total_income,
        };
    }
    return match ($sponsor->sponsor_type) {
        'other' => $sponsorContributions['other'],
        'widower' => $sponsorContributions['widower'],
        'widow' => $sponsorContributions['widow'],
        'widows_husband' => $sponsorContributions['widows_husband'],
        'widows_wife' => $sponsorContributions['widows_wife'],
        'mother_of_a_supported_childhood' => $sponsorContributions['mother_of_a_supported_childhood'],
        default => 0
    };
}

/**
 * @throws JsonException
 */
function calculateContributionsForHandicappedSponsor(Orphan $orphan): float
{
    return json_decode(
        $orphan->tenant['calculation'],
        true,
        512,
        JSON_THROW_ON_ERROR
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
    };
}

function calculateContributionsForFemaleOrphan(Orphan $orphan, array $calculations): float
{
    if (! $orphan->is_unemployed) {
        $calculations = $calculations['percentage_of_contribution']['orphans']['female_gt_18'];

        return match ($orphan->family_status) {
            'college_girl' => $calculations['college_girl'],
            'professional_girl' => $calculations['professional_girl'],
            'at_home_with_income' => $calculations['at_home_with_income'],
            'single_female_employee' => $calculations['single_female_employee'],
            'married' => $calculations['married'],
            'divorced' => $calculations['divorced'],
            default => 0
        };
    }

    return $calculations['unemployed_contribution']['orphans']['female_gt_18']['at_home_with_no_income'];
}
