<?php

/** @noinspection UnknownInspectionInspection */

use App\Models\Baby;
use App\Models\Family;
use App\Models\Inventory;
use App\Models\Orphan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

function listOfFamiliesBenefitingFromTheEidAlAdhaSponsorship(): LengthAwarePaginator
{
    return search(Family::getModel(), additional_filters: FILTER_EID_AL_ADHA)
        ->query(fn ($query) => $query
            ->with([
                'sponsor:id,first_name,last_name,family_id,phone_number',
                'zone:id,name',
                'branch:id,name',
                'eidAlAdhas:status,year,family_id',
            ])
            ->withCount('orphans'))
        ->paginate(perPage: request()->integer('perPage', 10));
}

function listOfFamiliesBenefitingFromTheZakatSponsorship(): LengthAwarePaginator
{
    return search(Family::getModel())
        ->query(fn ($query) => $query
            ->with([
                'sponsor:id,first_name,last_name,family_id,phone_number',
                'zone:id,name',
                'branch:id,name',
            ])
            ->withCount('orphans'))
        ->paginate(perPage: request()->integer('perPage', 10));
}

function listOfFamiliesBenefitingFromTheMeatDistributionSponsorship(): LengthAwarePaginator
{
    return search(Family::getModel())
        ->query(fn ($query) => $query
            ->with([
                'sponsor:id,first_name,last_name,family_id,phone_number',
                'zone:id,name',
                'branch:id,name',
            ])
            ->withCount('orphans'))
        ->paginate(perPage: request()->integer('perPage', 10));
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
        ->paginate(perPage: request()->integer('perPage', 10));
}

function listOfOrphansBenefitingFromTheSchoolEntrySponsorship(): LengthAwarePaginator
{
    return search(
        Orphan::getModel(),
        additional_filters: FILTER_SCHOOL_ENTRY
    )
        ->query(
            fn ($query) => $query
                ->with(
                    [
                        'sponsor:id,first_name,last_name,phone_number',
                        'family.zone:id,name',
                        'family:income_rate,zone_id,address,id',
                        'academicLevel:id,level,phase',
                    ]
                )
        )
        ->paginate(perPage: request()->integer('perPage', 10));
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
        ->paginate(perPage: request()->integer('perPage', 10));
}

function listOfOrphansBenefitingFromTheEidSuitSponsorship(): LengthAwarePaginator
{
    return search(
        Orphan::getModel(),
        additional_filters: FILTER_EID_SUIT(),
        limit: LIMIT
    )
        ->query(
            fn ($query) => $query
                ->with([
                    'sponsor:id,first_name,last_name,phone_number',
                    'family.zone:id,name',
                    'eidSuit.member:id,first_name,last_name',
                    'shoesSize',
                    'pantsSize',
                    'shirtSize',
                ])
        )
        ->paginate(perPage: request()->integer('perPage', 10));
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
        ->paginate(perPage: request()->integer('perPage', 10));
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
        ->paginate(perPage: request()->integer('perPage', 10));
}

function updateBasketItems(?array $items, ?array $deletedItems, Builder $basket): void
{
    if (! is_null($deletedItems) && $deletedItems !== []) {
        $basket->whereIn('id', $deletedItems)->delete();
    }

    if (! is_null($items) && $items !== []) {
        $inventoriesData = collect($items)
            ->map(fn ($item) => [
                'id' => $item['inventory_id'],
                'name' => $item['name'],
                'unit' => $item['unit'],
                'created_by' => auth()->user()?->id,
                'tenant_id' => auth()->user()?->tenant_id,
            ])
            ->unique('id')
            ->values()
            ->toArray();

        Inventory::upsert($inventoriesData, ['id'], ['name', 'unit', 'created_by', 'tenant_id']);

        $basketData = collect($items)
            ->map(fn ($item) => [
                'inventory_id' => $item['inventory_id'],
                'qty_for_family' => $item['qty_for_family'],
                'status' => $item['status'],
                'tenant_id' => auth()->user()?->tenant_id,
            ])
            ->toArray();

        $basket->upsert($basketData, ['inventory_id'], ['qty_for_family', 'status', 'tenant_id']);
    }
}
