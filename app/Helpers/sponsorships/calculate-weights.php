<?php

use App\Models\Family;
use App\Models\Orphan;
use Carbon\Carbon;

function calculateWeights(Family $family, array $calculation): float
{
    $calculationWeights = $calculation['weights']['orphans'];

    return $family->orphans->sum(fn (Orphan $orphan) => calculateOrphanWeights($orphan, $calculationWeights)) + calculateSponsorWeights($family) + calculateWeightForSecondSponsor($family);
}

function calculateSponsorWeights(Family $family): float
{
    $weights = json_decode((string) $family->tenant['calculation'], true)['weights']['sponsor'];

    return match ($family->sponsor->sponsor_type) {
        'other' => $weights['other'],
        'widower' => $weights['widower'],
        'widow' => $weights['widow'],
        'widows_husband' => $weights['widows_husband'] + 1,
        'mother_of_a_supported_childhood' => $weights['mother_of_a_supported_childhood'],
        'widowers_wife' => $weights['widowers_wife'],
    };
}

function calculateOrphanWeights(Orphan $orphan, array $orphanWeights): float
{
    if ($orphan->birth_date->age <= 18) {
        return calculateWeightForOrphanBelow18($orphan, $orphanWeights);
    }

    if ($orphan->is_handicapped) {
        return json_decode((string) $orphan->tenant['calculation'], true)['weights']['handicapped'];
    }

    if ($orphan->gender === 'male') {
        return calculateWeightForOrphanMaleOlderThan18($orphan, $orphanWeights);
    }

    return calculateWeightForOrphanFemaleOlderThan18($orphan, $orphanWeights);
}

function calculateWeightForOrphanFemaleOlderThan18(Orphan $orphan, array $weights): float
{
    $weights = $weights['female_gt_18'];

    if ($orphan->academicLevel?->phase_key === 'university' && $orphan->academicLevel?->level === 'متخرج') {
        return $weights['at_home_with_no_income'];
    }

    return match ($orphan->family_status) {
        'college_girl' => $weights['college_girl'],
        'professional_girl' => $weights['professional_girl'],
        'at_home_with_no_income' => $weights['at_home_with_no_income'],
        'at_home_with_income' => $weights['at_home_with_income'],
        'single_female_employee' => $weights['single_female_employee'],
        'married' => $weights['married'],
        'divorced_with_family' => $weights['divorced_with_family'],
        'divorced_outside_family' => $weights['divorced_outside_family'],
        default => 1
    };
}

function calculateWeightForOrphanMaleOlderThan18(Orphan $orphan, array $weights): float
{
    $weights = $weights['male_gt_18'];

    if ($orphan->academicLevel?->phase_key === 'university' && $orphan->academicLevel?->level === 'متخرج') {
        return $weights['unemployed'];
    }

    return match ($orphan->family_status) {
        'college_boy' => $weights['college_boy'],
        'professional_boy' => $weights['professional_boy'],
        'unemployed' => $weights['unemployed'],
        'worker_with_family' => $weights['worker_with_family'],
        'worker_outside_family' => $weights['worker_outside_family'],
        'married_with_family' => $weights['married_with_family'],
        'married_outside_family' => $weights['married_outside_family'],
        default => 1
    };
}

function calculateWeightForOrphanBelow18(Orphan $orphan, $weights): float
{
    $orphan = $orphan->load('academicLevel');

    if (Carbon::now()->month <= 9 && Carbon::now()->month >= 6) {
        if ($orphan->birth_date->age <= 2) {
            return $weights['lt_18']['outside_academic_season']['baby'];
        }

        if ($orphan->birth_date->age <= 5 && $orphan->birth_date->age > 2) {
            return $weights['lt_18']['outside_academic_season']['below_school_age'];
        }

        if ($orphan->family_status === 'professionals' || $orphan->academicLevel?->phase_key === 'vocational_training' ||
            $orphan->academicLevel?->phase_key === 'paramedical'
        ) {
            return $weights['lt_18']['outside_academic_season']['professionals'];
        }

        if ($orphan->academicLevel?->level === 'مفصول') {
            return $weights['lt_18']['outside_academic_season']['dismissed'];
        }

        if ($orphan->academicLevel?->phase) {
            return match ($orphan->academicLevel?->phase_key) {
                'primary_education' => $weights['lt_18']['outside_academic_season']['elementary_school'],
                'middle_education' => $weights['lt_18']['outside_academic_season']['middle_school'],
                'secondary_education' => $weights['lt_18']['outside_academic_season']['high_school'],
                default => 1
            };
        }

        return 1;
    }

    if ($orphan->birth_date->age <= 2) {
        return $weights['lt_18']['during_academic_season']['baby'];
    }

    if ($orphan->birth_date->age <= 5 && $orphan->birth_date->age > 2) {
        return $weights['lt_18']['during_academic_season']['below_school_age'];
    }

    if ($orphan->family_status === 'professionals' ||
        $orphan->academicLevel?->phase_key === 'vocational_training' ||
        $orphan->academicLevel?->phase_key === 'paramedical'
    ) {
        return $weights['lt_18']['during_academic_season']['professionals'];
    }

    if ($orphan->academicLevel?->level === 'مفصول') {
        return $weights['lt_18']['during_academic_season']['dismissed'];
    }

    if ($orphan->academicLevel?->phase) {
        return match ($orphan->academicLevel?->phase_key) {
            'primary_education' => $weights['lt_18']['during_academic_season']['elementary_school'],
            'middle_education' => $weights['lt_18']['during_academic_season']['middle_school'],
            'secondary_education' => $weights['lt_18']['during_academic_season']['high_school'],
            default => 1
        };
    }

    return match ($orphan->family_status) {
        'dismissed' => $weights['lt_18']['during_academic_season']['dismissed'],
        'professionals' => $weights['lt_18']['during_academic_season']['professionals'],
        default => 1
    };
}

function calculateWeightForSecondSponsor(Family $family): float
{
    $weights = json_decode((string) $family->tenant['calculation'], true)['weights']['second_sponsor'];

    if ($family->secondSponsor?->with_family) {
        return $weights['with_family'];
    }

    return 0;
}
