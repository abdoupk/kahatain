<?php

use App\Models\Family;
use App\Models\Housing;

function getFamiliesGroupedByZone(): array
{
    $families = Family::select('zone_id', DB::raw('count(*) as total'))->with('zone:id,name')
        ->groupBy('zone_id')
        ->get();

    return [
        'labels' => $families->pluck('zone.name')->toArray(),
        'data' => $families->pluck('total')->toArray(),
    ];
}

function getFamiliesGroupedByBranch(): array
{
    $families = Family::select('branch_id', DB::raw('count(*) as total'))->with('branch:id,name')
        ->groupBy('branch_id')
        ->get();

    return [
        'labels' => $families->pluck('branch.name')->toArray(),
        'data' => $families->pluck('total')->toArray(),
    ];
}

function getFamiliesGroupedByOrphansCount(): array
{
    $families = DB::table(
        DB::raw('(
        SELECT
            count(*) as total_families,
            orphans_count
        FROM (
            SELECT
                families.id,
                count(orphans.id) as orphans_count
            FROM families
            LEFT JOIN orphans ON families.id = orphans.family_id
            WHERE families.deleted_at IS NULL AND orphans.tenant_id = :tenant_id
            GROUP BY families.id
        ) as subquery
        GROUP BY orphans_count
        ORDER BY orphans_count ASC
    ) as subquery2')
    )->setBindings(['tenant_id' => tenant('id')])->get();

    return [
        'total_families' => $families->pluck('total_families')->toArray(),
        'orphans_count' => $families->pluck('orphans_count')->toArray(),
    ];
}

function getFamiliesGroupByDate(): array
{
    return array_replace(
        array_fill(1, 12, 0),
        Family::selectRaw('EXTRACT(MONTH FROM start_date) as month, COUNT(*) as families_count')
            ->whereYear('start_date', date('Y'))
            ->groupBy('month')
            ->pluck('families_count', 'month')
            ->toArray()
    );
}

function getFamiliesHousingTypes(): array
{
    $orphans = Housing::select('name', DB::raw('count(*) as total'))->groupBy('name')->get();

    return [
        'labels' => $orphans->pluck('name')->map(fn (string $familyStatus) => __('housing.label.'.$familyStatus))->toArray(),
        'data' => $orphans->pluck('total')->toArray(),
    ];
}
