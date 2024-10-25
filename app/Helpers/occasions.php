<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\Baby;
use App\Models\Family;
use App\Models\FamilySponsorship;
use App\Models\OrphanSponsorship;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function listOfFamiliesBenefitingFromTheEidAlAdhaSponsorship(): LengthAwarePaginator
{
    return search(FamilySponsorship::getModel(), additional_filters: FILTER_EID_AL_ADHA)
        ->query(fn ($query) => $query
            ->whereHas('family')
            ->with([
                'family:id,address,zone_id,branch_id,income_rate,total_income',
                'family.sponsor:id,first_name,last_name,family_id,phone_number',
                'family.zone:id,name',
                'family.branch:id,name',
            ])
            ->withCount('orphans'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfFamiliesBenefitingFromTheMonthlyBasket(): LengthAwarePaginator
{
    return search(FamilySponsorship::getModel())
        ->query(fn ($query) => $query
            ->whereHas('family')
            ->with(
                [
                    'family:id,address,income_rate,zone_id,branch_id,total_income',
                    'family.sponsor:id,first_name,last_name,family_id,phone_number',
                    'family.zone:id,name',
                    'family.branch:id,name',
                ]
            )->withCount('orphans'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfOrphansBenefitingFromTheSchoolEntrySponsorship(): LengthAwarePaginator
{
    return search(
        OrphanSponsorship::getModel(),
        additional_filters: FILTER_SCHOOL_ENTRY()
    )
        ->query(
            fn ($query) => $query
                ->whereHas('orphan.family')
                ->with(
                    [
                        'orphan.sponsor:id,first_name,last_name,phone_number',
                        'orphan.lastAcademicYearAchievement.academicLevel',
                        'orphan.family.zone:id,name',
                    ]
                )
        )
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfFamiliesBenefitingFromTheRamadanBasketSponsorship(): LengthAwarePaginator
{
    return search(
        FamilySponsorship::getModel(),
        additional_filters: FILTER_RAMADAN_BASKET
    )
        ->query(fn ($query) => $query
            ->whereHas('family')
            ->with([
                'family:id,address,zone_id,branch_id,total_income,income_rate',
                'family.sponsor:id,first_name,last_name,family_id,phone_number',
                'family.zone:id,name',
                'family.branch:id,name',
            ])
            ->withCount('orphans'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfOrphansBenefitingFromTheEidSuitSponsorship(): LengthAwarePaginator
{
    return search(
        OrphanSponsorship::getModel(),
        FILTER_EID_SUIT
    )
        ->query(
            fn ($query) => $query
                ->whereHas('orphan.family')
                ->with([
                    'orphan:id,first_name,last_name,family_id,sponsor_id,shoes_size,pants_size,shirt_size,birth_date',
                    'orphan.sponsor:id,first_name,last_name,phone_number',
                    'orphan.family.zone:id,name',
                    'orphan.shoesSize',
                    'orphan.pantsSize',
                    'orphan.shirtSize',
                ])
        )
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfBabies(): LengthAwarePaginator
{
    return search(Baby::getModel(), 'AND orphan.birth_date > '.strtotime('now - 2 years'))
        ->query(
            fn ($query) => $query
                ->whereHas('orphan.family')
                ->with(
                    [
                        'orphan:id,first_name,last_name,family_id,birth_date,sponsor_id',
                        'orphan.sponsor:id,first_name,last_name,phone_number',
                        'babyMilk:id,name',
                        'diapers:id,name',
                        'orphan.family.zone:id,name',
                    ]
                )
        )
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function FILTER_SCHOOL_ENTRY(): string
{
    $last_academic_year = date('Y') - 1;

    return "AND school_bag = true AND school_bag IS NOT NULL AND orphan.academic_achievement.academic_year IS NOT EMPTY AND orphan.academic_achievement.academic_year >= {$last_academic_year}";
}

function listOfFamiliesBenefitingFromTheMonthlySponsorship(): LengthAwarePaginator
{
    return search(Family::getModel())
        ->query(fn ($query) => $query
            ->with(
                [
                    'sponsor:id,first_name,last_name,family_id,phone_number',
                    'zone:id,name',
                    'branch:id,name',
                    'aid',
                ]
            )->withCount('orphans'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}
