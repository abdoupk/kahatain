<?php

use App\Models\Archive;

function getStatisticsForBabiesMilkAndDiaper(): array
{
    return array_replace(array_fill(1, 12, 0), Archive::withCount('babies')->whereOccasion('babies_milk_and_diapers')
        ->whereYear('created_at', request()->integer('babies_milk_and_diapers_year', date('Y')))
        ->selectRaw('EXTRACT(MONTH FROM created_at) as month')
        ->pluck('babies_count', 'month')
        ->toArray());
}

function getStatisticsForEidAlAdha(): array
{
    return Archive::with('families.eidAlAdhas')
        ->whereOccasion('eid_al_adha')
        ->whereYear('archives.created_at', request()->integer('eid_al_adha_year', date('Y')))
        ->selectRaw("
        archives.id,
        EXTRACT(YEAR FROM archives.created_at) as year,
        SUM(CASE WHEN family_eid_al_adhas.status = 'sacrificed' THEN 1 ELSE 0 END) as sacrificed_count,
        SUM(CASE WHEN family_eid_al_adhas.status = 'benefit' THEN 1 ELSE 0 END) as benefit_count,
        SUM(CASE WHEN family_eid_al_adhas.status = 'dont_benefit' THEN 1 ELSE 0 END) as dont_benefit_count,
        SUM(CASE WHEN family_eid_al_adhas.status = 'meat' THEN 1 ELSE 0 END) as meat_count,
        SUM(CASE WHEN family_eid_al_adhas.status = 'benefactor' THEN 1 ELSE 0 END) as benefactor_count
    ")
        ->join('archiveables', fn ($join) => $join
            ->on('archives.id', '=', 'archiveables.archive_id')
            ->where('archiveables.archiveable_type', '=', 'family')
        )
        ->join('families', 'families.id', '=', 'archiveables.archiveable_id')
        ->join('family_eid_al_adhas', fn ($join) => $join
            ->on('families.id', '=', 'family_eid_al_adhas.family_id')
            ->where('family_eid_al_adhas.year', '=', request()->integer('eid_al_adha_year', date('Y')))
        )
        ->groupByRaw('archives.id, EXTRACT(YEAR FROM archives.created_at)')
        ->get()
        ->map(fn ($archive) => [
            'sacrificed' => $archive->sacrificed_count,
            'benefit' => $archive->benefit_count,
            'dont_benefit' => $archive->dont_benefit_count,
            'meat' => $archive->meat_count,
            'benefactor' => $archive->benefactor_count,
        ])->toArray();
}

function getStatisticsForSchoolEntry(): array
{
    return Archive::join('archiveables', 'archiveables.archive_id', '=', 'archives.id')
        ->join('orphans', 'orphans.id', '=', 'archiveables.archiveable_id')
        ->where('archives.occasion', 'school_entry')
        ->selectRaw(
            "EXTRACT(YEAR FROM archives.created_at) as year,
            SUM(case when orphans.gender = 'male' then 1 else 0 end) as male_count,
            SUM(case when orphans.gender = 'female' then 1 else 0 end) as female_count"
        )
        ->groupBy('year')
        ->get()
        ->toArray();
}

function getStatisticsForMonthlySponsorship(): array
{
    return array_replace(array_fill(1, 12, 0), Archive::withCount('families')->whereOccasion('monthly_sponsorship')
        ->whereYear('created_at', request()->integer('monthly_sponsorship_year', date('Y')))
        ->selectRaw('EXTRACT(MONTH FROM created_at) as month')
        ->pluck('families_count', 'month')
        ->toArray());
}

function getStatisticsForRamadanBasket(): array
{
    return Archive::join('archiveables', 'archiveables.archive_id', '=', 'archives.id')
        ->join('families', 'families.id', '=', 'archiveables.archiveable_id')
        ->whereOccasion('ramadan_basket')
        ->select(
            DB::raw('EXTRACT(YEAR FROM archives.created_at) as year'),
            'families.ramadan_basket_category',
            DB::raw('count(*) as count')
        )
        ->groupBy('year', 'families.ramadan_basket_category')
        ->get()
        ->groupBy('year')->map(fn ($yearGroup) => $yearGroup->pluck('count', 'ramadan_basket_category'))->toArray();
}

function getStatisticsForMeatDistribution(): array
{
    return array_replace(
        array_fill(1, 12, 0),
        Archive::join('archiveables', fn ($join) => $join
            ->on('archives.id', '=', 'archiveables.archive_id')
            ->where('archiveables.archiveable_type', '=', 'family')
        )
            ->join('families', 'families.id', '=', 'archiveables.archiveable_id')
            ->whereOccasion('meat_distribution')
            ->whereYear('archives.created_at', request()->integer('meat_distribution_year', date('Y')))
            ->selectRaw('EXTRACT(MONTH FROM archives.created_at) as month, COUNT(DISTINCT families.id) as families_count')
            ->groupBy('month')
            ->pluck('families_count', 'month') // Retrieve the families count for each month
            ->toArray()
    );
}

function getStatisticsForEidSuit(): array
{
    return Archive::join('archiveables', 'archiveables.archive_id', '=', 'archives.id')
        ->join('orphans', 'orphans.id', '=', 'archiveables.archiveable_id')
        ->where('archives.occasion', 'eid_suit')
        ->selectRaw(
            "EXTRACT(YEAR FROM archives.created_at) as year,
            SUM(case when orphans.gender = 'male' then 1 else 0 end) as male_count,
            SUM(case when orphans.gender = 'female' then 1 else 0 end) as female_count"
        )
        ->groupBy('year')
        ->get()
        ->toArray();
}

function getStatisticsForZakat(): array
{
    return array_replace(
        array_fill(1, 12, 0),
        Archive::whereOccasion('zakat')
            ->whereYear('created_at', request()->integer('zakat_year', date('Y')))
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, SUM((metadata->>\'amount\')::numeric) as amount')
            ->groupBy('month')
            ->pluck('amount', 'month')
            ->toArray()
    );
}
