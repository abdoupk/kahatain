<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\Baby;
use App\Models\Family;
use App\Models\Orphan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

function listOfFamiliesBenefitingFromTheEidAlAdhaSponsorship(): LengthAwarePaginator
{
    return search(Family::getModel(), additional_filters: FILTER_EID_AL_ADHA)
        ->query(fn ($query) => $query
            ->with([
                'sponsor:id,first_name,last_name,family_id,phone_number',
                'zone:id,name',
                'branch:id,name',
            ])
            ->withCount('orphans'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfFamiliesBenefitingFromTheMonthlyBasket(): LengthAwarePaginator
{
    return search(Family::getModel())
        ->query(fn ($query) => $query
            ->with(
                [
                    'sponsor:id,first_name,last_name,family_id,phone_number',
                    'zone:id,name',
                    'branch:id,name',
                ]
            )->withCount('orphans'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfOrphansBenefitingFromTheSchoolEntrySponsorship(): LengthAwarePaginator
{
    return search(
        Orphan::getModel(),
        additional_filters: FILTER_SCHOOL_ENTRY()
    )
        ->query(
            fn ($query) => $query
                ->with(
                    [
                        'sponsor:id,first_name,last_name,phone_number',
                        'lastAcademicYearAchievement.academicLevel',
                        'family.zone:id,name',
                        'family:income_rate,zone_id,address,id',
                    ]
                )
        )
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfFamiliesBenefitingFromTheRamadanBasketSponsorship(): LengthAwarePaginator
{
    return search(
        Family::getModel(),
        additional_filters: FILTER_RAMADAN_BASKET
    )
        ->query(fn ($query) => $query
            ->with([
                'sponsor:id,first_name,last_name,family_id,phone_number',
                'zone:id,name',
                'branch:id,name',
                'aid',
            ])
            ->withCount('orphans'))
        ->paginate(perPage: request()?->integer('perPage', 10));
}

function listOfOrphansBenefitingFromTheEidSuitSponsorship(): LengthAwarePaginator
{
    return search(
        Orphan::getModel(),
        FILTER_EID_SUIT
    )
        ->query(
            fn ($query) => $query
                ->with([
                    'sponsor:id,first_name,last_name,phone_number',
                    'family.zone:id,name',
                    'shoesSize',
                    'pantsSize',
                    'shirtSize',
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
    //    $last_academic_year = date('Y') - 1;

    return '';

    //    return "AND academic_achievement.academic_year IS NOT EMPTY AND academic_achievement.academic_year >= $last_academic_year";
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
